<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Fpdf;
use Image;
use App\User;
use App\Municipio;
use App\Medico;
use App\Asistente;
use App\Historia_ginecologica;
use Carbon\Carbon;
use App\Paciente;
use App\Medico_paciente;


class PDF extends Fpdf
{

	public  $widths;
	public  $aligns;

	function SetWidths($w)
	{
		//Set the array of column widths
		$this->widths=$w;
	}

	function SetAligns($a)
	{
		//Set the array of column alignments
		$this->aligns=$a;
	}

	function Row($data)
	{
		//Calculate the height of the row
		$nb=0;
		for($i=0;$i<count($data);$i++)
			$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
		$h=4*$nb;
		//Issue a page break first if needed
		$this->CheckPageBreak($h);
		//Draw the cells of the row
		for($i=0;$i<count($data);$i++)
		{
			$w=$this->widths[$i];
			$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
			//Save the current position
			$x=$this->GetX();
			$y=$this->GetY();
			//Draw the border

			$this->Rect($x,$y,$w,$h,'DF');
			//Print the text
			$this->MultiCell($w,4,utf8_decode($data[$i]),0,$a);
			//Put the position to the right of the cell
			$this->SetXY($x+$w,$y);
		}
		//Go to the next line
		$this->Ln($h);
	}

	function CheckPageBreak($h)
	{
		//If the height h would cause an overflow, add a new page immediately
		if($this->GetY()+$h>$this->PageBreakTrigger)
			$this->AddPage($this->CurOrientation);
	}

	function NbLines($w,$txt)
	{
	//Computes the number of lines a MultiCell of width w will take
		$cw=&$this->CurrentFont['cw'];
		if($w==0)
			$w=$this->w-$this->rMargin-$this->x;
		$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
		$s=str_replace("\r",'',$txt);
		$nb=strlen($s);
		if($nb>0 and $s[$nb-1]=="\n")
			$nb--;
		$sep=-1;
		$i=0;
		$j=0;
		$l=0;
		$nl=1;
		while($i<$nb)
		{
			$c=$s[$i];
			if($c=="\n")
			{
				$i++;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
				continue;
			}
			if($c==' ')
				$sep=$i;
			$l+=$cw[$c];
			if($l>$wmax)
			{
				if($sep==-1)
				{
					if($i==$j)
						$i++;
				}
				else
					$i=$sep+1;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
			}
			else
				$i++;
		}
		return $nl;
	}
	function Footer()
	{
		
		$fecha_hora_actual= date('d/m/Y')." ".date("h:i:s a");
		$this->SetFont('Arial','I',8);
		$this->Ln();
		$this->SetY(-15);
		$this->Cell(95,5,utf8_decode("Historias Clinicas Derechos Reservados ".date('Y').""), 0, '', 'L');
		$this->Cell(95,5,utf8_decode("Página " . $this->PageNo() . " - Fecha de Impresión " . $fecha_hora_actual), 0, '', 'R');
	}

	function RotatedText($x,$y,$txt,$angle)
	{
	    //Text rotated around its origin
	    $this->Rotate($angle,$x,$y);
	    $this->Text($x,$y,$txt);
	    $this->Rotate(0);
	}
}


class ReportsGinecologiaController extends Controller
{

//--------------CONSULTA----------------//
	public function ginecologia_consulta($historia_ginecologica_id)
	{
		$dia='';
    	$mes='';
    	$anio='';
    	$trabajador='';
    	$empresa='';
    	$cedula='';
    	$cargo='';
    	$edad='';
    	$ocupacion='';
    	$estadocivil='';
    	$genero='';
    	$fechanacimiento='';
		$telefono='';
		$direccion='';

    	$eps='';
    	$afp='';
    	$arl='';
    	$municipio='';
    	$firmatrabajador='';
    	$tipoexamen='';

    	$peso='';
    	$talla='';
    	$imc='';
    	$ta='';
    	$fc='';
    	$fr='';
    	$lateralidad='';
    	$condicion='';
	    $observacion='';
	    $medico='';
	    $registro='';
	    $firmamedico='';
	    $banner='';
	    $recomendaciones='';


		$historia_ginecologica = Historia_ginecologica::where('id',$historia_ginecologica_id)->with('medico_paciente.paciente.user')->with('medico_paciente.medico.user')->first();
		if(!is_null($historia_ginecologica))
		{

			$dia=$historia_ginecologica->created_at->format('d');
			$mes=$historia_ginecologica->created_at->format('m');
			$anio=$historia_ginecologica->created_at->format('Y');
			$trabajador=$historia_ginecologica->medico_paciente->paciente->user->primerapellido.' '.$historia_ginecologica->medico_paciente->paciente->user->primernombre;
			$empresa=$historia_ginecologica->empresa;
			$cedula=$historia_ginecologica->medico_paciente->paciente->user->tipodocumento.' '.$historia_ginecologica->medico_paciente->paciente->user->numerodocumento;
			$ocupacion=$historia_ginecologica->medico_paciente->paciente->user->ocupacion;
			$estadocivil=$historia_ginecologica->medico_paciente->paciente->user->estadocivil;
			$fechanacimiento=$historia_ginecologica->medico_paciente->paciente->user->fechanacimiento->format('d/m/Y');
			$edad=$historia_ginecologica->medico_paciente->paciente->user->fechanacimiento->diff(Carbon::now())->format('%y años');
			$genero=$historia_ginecologica->medico_paciente->paciente->user->genero;
			$telefono=$historia_ginecologica->medico_paciente->paciente->user->telefono;
			$direccion=$historia_ginecologica->medico_paciente->paciente->user->direccion;
			$municipio=$historia_ginecologica->medico_paciente->paciente->municipio_id;
			if($municipio==0){
				$municipio='N/A';
			}else{
				$municipio_residencia = municipio::where('id',$municipio)->first();
				if(!is_null($municipio_residencia))
				{
					$municipio=$municipio_residencia->descripcion;
				}else{
					$municipio='N/A';
				}
			}
			$firmatrabajador=$historia_ginecologica->medico_paciente->paciente->user->firma;
		//	$cargo=$historia_ocupacional->ocupacional_actual->cargoactual;
			
		/*	$query_eps = Empresa::where('id',$historia_ocupacional->empresa_id)->first();
			if(!is_null($query_eps)){ $eps=utf8_decode($query_eps->descripcion);}else{$eps='N/A';}

			$afp=$historia_ocupacional->afp->descripcion;
			$arl=$historia_ocupacional->arl->descripcion;

			

			/*$peso=$historia_ocupacional->examen_fisico->peso;
	    	$talla=$historia_ocupacional->examen_fisico->talla;
	    	$imc=$historia_ocupacional->examen_fisico->imc;
	    	$ta=$historia_ocupacional->examen_fisico->ta;
	    	$fc=$historia_ocupacional->examen_fisico->fc;
	    	$fr=$historia_ocupacional->examen_fisico->fr;
	    	$lateralidad=$historia_ocupacional->examen_fisico->lateralidad->descripcion;
			$tipoexamen=utf8_decode($historia_ocupacional->tipo_examen->descripcion);
			$condicion=$historia_ocupacional->condicion_diagnostico->tipo_condicion->descripcion;
	    	$observacion=$historia_ocupacional->condicion_diagnostico->observacion;*/
	    	
	    	$medico=utf8_decode($historia_ginecologica->medico_paciente->medico->user->primerapellido.' '.$historia_ginecologica->medico_paciente->medico->user->primernombre);
	    	$registro=utf8_decode($historia_ginecologica->medico_paciente->medico->registro);
	    	$firmamedico=utf8_decode($historia_ginecologica->medico_paciente->medico->user->firma);
	    	$banner=utf8_decode($historia_ginecologica->medico_paciente->medico->banner);
	    	$recomendaciones=utf8_decode($historia_ginecologica->recomendaciones);
		}

		$fpdf = new PDF('L','mm','letter');
        $fpdf->AddPage();
        $fpdf->SetTextColor(0,0,0);
		$fpdf->SetFillColor(255,255,255);

        if(file_exists( public_path().'/images/banner/'.$banner) &&  $banner!='' ){
			$fpdf->Image(asset('images/banner/'.$banner),10,8,95,15);
		}

        
        $fpdf->SetY(40);
		$fpdf->SetTitle("Certificado Laboral");
		$fpdf->SetFont('Arial','B',10);
		$fpdf->Cell(100,6,'RECOMENDACIONES',1,0,'C',0);
		$fpdf->Ln();




		$fpdf->SetFont('Arial','B',9);
		$fpdf->Cell(190,5,'Datos Personales ',1,0,'C',0);
		$fpdf->Ln();

	/*	$fpdf->SetWidths(array(100,55,35));
		$fpdf->SetAligns(array('L','C','C'));
		$fpdf->SetFont('Arial','B',9);
		$fpdf->Row(array('Nombre y Apellido','Documento','Edad'));
		$fpdf->SetFont('Arial','',9);
		$fpdf->Row(array($trabajador,$cedula,$edad));


		$fpdf->SetWidths(array(30,30,30,100));
		$fpdf->SetAligns(array('C','C','C','C'));
		$fpdf->SetFont('Arial','B',9);
		$fpdf->Row(array('Fecha Nac.','Genero','Estado Civil','Ocupacion'));
		$fpdf->SetFont('Arial','',9);
		$fpdf->Row(array($fechanacimiento,$genero,$estadocivil,$ocupacion));


		
		$fpdf->SetWidths(array(30,60,100));
		$fpdf->SetAligns(array('C','C','L'));
		$fpdf->SetFont('Arial','B',9);
		$fpdf->Row(array('Teléfono','Ciudad','Dirección'));
		$fpdf->SetFont('Arial','',9);
		$fpdf->Row(array($telefono,$municipio,$direccion));


		$fpdf->SetFont('Arial','B',9);
		$fpdf->Cell(190,5,'Datos Ocupacionales ',1,0,'C',0);
		$fpdf->Ln();

		$fpdf->SetWidths(array(120,70));
		$fpdf->SetAligns(array('L','C'));
		$fpdf->SetFont('Arial','B',9);
		$fpdf->Row(array('Empresa','Cargo'));
		$fpdf->SetFont('Arial','',9);
		$fpdf->Row(array($empresa,$cargo));

		$fpdf->SetWidths(array(63.3,63.3,63.3));
		$fpdf->SetAligns(array('L','L','L'));
		$fpdf->SetFont('Arial','B',9);
		$fpdf->Row(array('AFP','ARL','EPS'));
		$fpdf->SetFont('Arial','',9);
		$fpdf->Row(array($afp,$arl,$eps));

		$fpdf->Ln();
		$fpdf->SetFont('Arial','B',8);
		$fpdf->Cell(190,5,utf8_decode('CONCEPTO MÉDICO DE APTITUD  OCUPACIONAL'),1,0,'C',0);
		$fpdf->Ln();

		$fpdf->SetWidths(array(75,40,75));
		$fpdf->SetAligns(array('L','C','C'));
		$fpdf->SetFont('Arial','B',9);
		$fpdf->Row(array('Tipo de Certificado','Fecha','Condición'));
		$fpdf->SetFont('Arial','',9);
		$fpdf->Row(array($tipoexamen,$dia.'/'.$mes.'/'.$anio,$condicion));

		$alto=$fpdf->GetY()+20;
		$fpdf->SetFont('Arial','',8);
		$fpdf->Rect(10,$fpdf->GetY(),190,15,'D');
		$fpdf->MultiCell(190,4,utf8_decode(''.$observacion),0,'J',0);

		$fpdf->SetY($alto);
		$fpdf->SetFont('Arial','B',8);
		$fpdf->Cell(190,6,utf8_decode('AYUDAS DIAGNÓSTICAS'),1,0,'C',0);

		
		$fpdf->Ln();

		$fpdf->SetWidths(array(80,25,85));
		$fpdf->SetAligns(array('L','C','L'));
		$fpdf->Row(array('Examen','Fecha','Resultado'));
		$fpdf->SetFont('Arial','',8);
		$Examen_laboratorios= Examen_laboratorio::where(['historia_ocupacional_id' => $historia_ocupacional->id])->orderBy('id')->get();
		$i=0;
		foreach($Examen_laboratorios as $Examen_laboratorio){

			$fpdf->Row(array($Examen_laboratorio->examen,$Examen_laboratorio->fecha->format('d/m/Y'),$Examen_laboratorio->resultado));
			$i=$i+1;
		}

		for($i=$i;$i<10;$i++)
		{
			$fpdf->Row(array('','',''));
		}

		$ancho_reco=$fpdf->GetY();
		$fpdf->Ln();
		$fpdf->SetFont('Arial','B',8);
		$fpdf->Cell(190,5,utf8_decode('RECOMENDACIONES MÉDICO LABORAL'),1,0,'C',0);
		$fpdf->Ln();


		$fpdf->Rect(10,$fpdf->GetY(),190,20,'D');
		$fpdf->SetFont('Arial','',8);
		$fpdf->MultiCell(190,4,$recomendaciones,0,'J',0);
		$fpdf->SetY($ancho_reco+35);
		$fpdf->SetFont('Arial','',7);
		$fpdf->Rect(10,$fpdf->GetY()-2,190,22,'D');
		$fpdf->MultiCell(190,3,utf8_decode('CONSIDERACIONES LEGALES RELATIVAS A LOS EXAMENES DE INGRESO: Las resoluciones 2346 de 2007 y 1818 de 2009 del Ministerio de la Protección Social actualmente Ministerios de Trabajo y de Salud y Protección Social reglamentan la práctica y contenido de las evaluaciones médicas ocupacionales. Se establece que la empresa solo puede conocer el CERTIFICADO MEDICO DE APTITUD del aspirante.  Los resultados de los exámenes se dan a conocer en el certificado con la autorización del aspirante. Los documentos completos de la Historia Clínica Ocupacional están  sometidos a reserva profesional y quedan bajo nuestra custodia según lo establecido en la Resolución 1918 de 2009. El trabajador puede obtener copia en el momento que lo requiera, entendiendo que hacen parte integral de su historial 
			NOTA: Bajo la gravedad del juramento afirmo que toda la información anteriormente suministrada es correcta y que no he ocultado nada sobre mi historia de salud.'),0,'J',0);


		$fpdf->SetY(265);
		if(file_exists( public_path().'/images/firmas/'.$firmatrabajador) &&  $firmatrabajador!='' ){
			$fpdf->Image(asset('images/firmas/'.$firmatrabajador),130,252,45,15);
		}
		if(file_exists( public_path().'/images/firmas/'.$firmamedico) &&  $firmamedico!='' ){
			$fpdf->Image(asset('images/firmas/'.$firmamedico),35,252,45,15);
		}
		$fpdf->SetFont('Arial','',9);

		$fpdf->Cell(95,3,'_______________________________',0,0,'C',0);
		$fpdf->Cell(95,3,'_______________________________',0,0,'C',0);
		
		$fpdf->Ln();
		$fpdf->Cell(95,5,$medico,0,0,'C',0);
		$fpdf->Cell(95,5,$trabajador,0,0,'C',0);*/

		$fpdf->Ln();
		$fpdf->SetFont('Arial','',9);
		$fpdf->Cell(95,3,utf8_decode('Registro Médico ').$registro,0,0,'C',0);
		$fpdf->Cell(95,3,$cedula,0,0,'C',0);
    	$fpdf->Output();
        exit;



	}

//--------------CUESTIONARIO PARA TRABAJO EN ALTURAS----------------//
    public function trabajo_altura($historia_ocupacional_id){

    	$dia='';
    	$mes='';
    	$anio='';
    	$trabajador='';
    	$empresa='';
    	$cedula='';
    	$cargo='';
    	$edad='';
    	$ocupacion='';
    	$estadocivil='';
    	$genero='';
    	$fechanacimiento='';
		$telefono='';
		$direccion='';

    	$eps='';
    	$afp='';
    	$arl='';
    	$municipio='';
    	$firmatrabajador='';
    	$tipoexamen='';

    	$peso='';
    	$talla='';
    	$imc='';
    	$ta='';
    	$fc='';
    	$fr='';
    	$lateralidad='';
    	$condicion='';
	    $observacion='';
	    $medico='';
	    $registro='';
	    $firmamedico='';
	    $banner='';

		$historia_ocupacional = Historia_ocupacional::where('id',$historia_ocupacional_id)->with('arl')->with('afp')->with('empresa')->with('medico_paciente.paciente.user')->with('medico_paciente.medico.user')->with('ocupacional_actual')->with('examen_fisico.lateralidad')->with('condicion_altura.tipo_condicion')->first();
		if(!is_null($historia_ocupacional))
		{

			$dia=$historia_ocupacional->created_at->format('d');
			$mes=$historia_ocupacional->created_at->format('m');
			$anio=$historia_ocupacional->created_at->format('Y');
			$trabajador=$historia_ocupacional->medico_paciente->paciente->user->primerapellido.' '.$historia_ocupacional->medico_paciente->paciente->user->primernombre;
			$empresa=$historia_ocupacional->empresa;
			$cedula=$historia_ocupacional->medico_paciente->paciente->user->tipodocumento.' '.$historia_ocupacional->medico_paciente->paciente->user->numerodocumento;
			$ocupacion=$historia_ocupacional->medico_paciente->paciente->user->ocupacion;
			$estadocivil=$historia_ocupacional->medico_paciente->paciente->user->estadocivil;
			$fechanacimiento=$historia_ocupacional->medico_paciente->paciente->user->fechanacimiento->format('d/m/Y');
			$edad=$historia_ocupacional->medico_paciente->paciente->user->fechanacimiento->diff(Carbon::now())->format('%y años');
			$genero=$historia_ocupacional->medico_paciente->paciente->user->genero;
			$telefono=$historia_ocupacional->medico_paciente->paciente->user->telefono;
			$direccion=$historia_ocupacional->medico_paciente->paciente->user->direccion;
			$municipio=$historia_ocupacional->medico_paciente->paciente->municipio_id;
			if($municipio==0){
				$municipio='N/A';
			}else{
				$municipio_residencia = municipio::where('id',$municipio)->first();
				if(!is_null($municipio_residencia))
				{
					$municipio=$municipio_residencia->descripcion;
				}else{
					$municipio='N/A';
				}
			}

			$cargo=$historia_ocupacional->ocupacional_actual->cargoactual;
			$firmatrabajador=$historia_ocupacional->medico_paciente->paciente->user->firma;
			$query_eps = Empresa::where('id',$historia_ocupacional->empresa_id)->first();
			if(!is_null($query_eps)){ $eps=utf8_decode($query_eps->descripcion);}else{$eps='N/A';}

			$afp=$historia_ocupacional->afp->descripcion;
			$arl=$historia_ocupacional->arl->descripcion;
			$peso=$historia_ocupacional->examen_fisico->peso;
	    	$talla=$historia_ocupacional->examen_fisico->talla;
	    	$imc=$historia_ocupacional->examen_fisico->imc;
	    	$ta=$historia_ocupacional->examen_fisico->ta;
	    	$fc=$historia_ocupacional->examen_fisico->fc;
	    	$fr=$historia_ocupacional->examen_fisico->fr;
	    	$lateralidad=$historia_ocupacional->examen_fisico->lateralidad->descripcion;
	       	$condicion=$historia_ocupacional->condicion_altura->tipo_condicion->descripcion;
	    	$observacion=$historia_ocupacional->condicion_altura->observacion;
	    	$medico=utf8_decode($historia_ocupacional->medico_paciente->medico->user->primerapellido.' '.$historia_ocupacional->medico_paciente->medico->user->primernombre);
	    	$registro=utf8_decode($historia_ocupacional->medico_paciente->medico->registro);
	    	$firmamedico=utf8_decode($historia_ocupacional->medico_paciente->medico->user->firma);
	    	$banner=utf8_decode($historia_ocupacional->medico_paciente->medico->banner);



		}
    	
      	$fpdf = new PDF();
        $fpdf->AddPage();
        $fpdf->SetTextColor(0,0,0);
		$fpdf->SetFillColor(255,255,255);

        if(file_exists( public_path().'/images/banner/'.$banner) &&  $banner!='' ){
			$fpdf->Image(asset('images/banner/'.$banner),10,8,190,30);
		}

        $fpdf->AliasNbPages();
        $fpdf->SetY(40);
		$fpdf->SetTitle("Cuestionario Altura");
		$fpdf->SetFont('Arial','B',10);
		$fpdf->Cell(190,6,'CUESTIONARIO PARA TRABAJO EN ALTURAS',1,0,'C',0);
		$fpdf->Ln();

		$fpdf->SetFont('Arial','B',9);
		$fpdf->Cell(190,5,'Datos Personales ',1,0,'C',0);
		$fpdf->Ln();

		$fpdf->SetWidths(array(100,55,35));
		$fpdf->SetAligns(array('L','C','C'));
		$fpdf->SetFont('Arial','B',9);
		$fpdf->Row(array('Nombre y Apellido','Documento','Edad'));
		$fpdf->SetFont('Arial','',9);
		$fpdf->Row(array($trabajador,$cedula,$edad));


		$fpdf->SetWidths(array(30,30,30,100));
		$fpdf->SetAligns(array('C','C','C','C'));
		$fpdf->SetFont('Arial','B',9);
		$fpdf->Row(array('Fecha Nac.','Genero','Estado Civil','Ocupacion'));
		$fpdf->SetFont('Arial','',9);
		$fpdf->Row(array($fechanacimiento,$genero,$estadocivil,$ocupacion));


		
		$fpdf->SetWidths(array(30,60,100));
		$fpdf->SetAligns(array('C','C','L'));
		$fpdf->SetFont('Arial','B',9);
		$fpdf->Row(array('Teléfono','Ciudad','Dirección'));
		$fpdf->SetFont('Arial','',9);
		$fpdf->Row(array($telefono,$municipio,$direccion));


		$fpdf->SetFont('Arial','B',9);
		$fpdf->Cell(190,5,'Datos Ocupacionales ',1,0,'C',0);
		$fpdf->Ln();

		$fpdf->SetWidths(array(120,70));
		$fpdf->SetAligns(array('L','C'));
		$fpdf->SetFont('Arial','B',9);
		$fpdf->Row(array('Empresa','Cargo'));
		$fpdf->SetFont('Arial','',9);
		$fpdf->Row(array($empresa,$cargo));

		$fpdf->SetWidths(array(63.3,63.3,63.3));
		$fpdf->SetAligns(array('L','L','L'));
		$fpdf->SetFont('Arial','B',9);
		$fpdf->Row(array('AFP','ARL','EPS'));
		$fpdf->SetFont('Arial','',8);
		$fpdf->Row(array($afp,$arl,$eps));

		$fpdf->SetFont('Arial','B',9);
		$fpdf->Cell(190,5,utf8_decode('Exploración Física'),1,0,'C',0);
		$fpdf->Ln();

		$fpdf->SetWidths(array(31.7,31.7,31.7,31.7,31.7,31.7));
		$fpdf->SetAligns(array('C','C','C','C','C','C'));
		$fpdf->SetFont('Arial','B',9);
		$fpdf->Row(array('Peso','Talla','IMC','TA','FC','FR'));
		$fpdf->SetFont('Arial','',9);
		$fpdf->Row(array(number_format($peso,2),number_format($talla,2),$imc,$ta,$fc,$fr));

	
		$fpdf->SetFont('Arial','',8);
		$fpdf->Ln();
		$fpdf->Cell(140,5,'',0,0,'L',0);
		$fpdf->Cell(25,5,'SI',1,0,'C',0);
		$fpdf->Cell(25,5,'NO',1,0,'C',0);

		$tipo_examen_alturas = Tipo_examen_altura::orderby('id')->get();
		foreach ( $tipo_examen_alturas as $tipo_examen_altura ){
			$examen_altura= Examen_altura::where(['historia_ocupacional_id' => $historia_ocupacional->id,'tipo_examen_altura_id' => $tipo_examen_altura->id])->first();
			if(is_null($examen_altura))
			{
				$si='';
				$no='X';
			}else{
				$si='X';
				$no='';
			}
			$fpdf->Ln();
			$fpdf->Cell(140,4,utf8_decode($tipo_examen_altura->descripcion),1,0,'L',0);
			$fpdf->Cell(25,4,$si,1,0,'C',0);
			$fpdf->Cell(25,4,$no,1,0,'C',0);

		}
			
		$fpdf->Ln(8);
		$fpdf->SetFont('Arial','B',9);
		$fpdf->Cell(150,5,utf8_decode('CONDICIÓN PARA TRABAJAR EN ALTURAS'),1,0,'L',0);
		$fpdf->Cell(40,5,utf8_decode('FECHA'),1,0,'L',0);
		$fpdf->Ln();
		$fpdf->SetFont('Arial','',9);
		$fpdf->Cell(150,5,$condicion,1,0,'L',0);
		$fpdf->Cell(40,5,$dia.'/'.$mes.'/'.$anio,1,0,'C',0);
		$fpdf->Ln();
		$fpdf->SetFont('Arial','',8);
		$fpdf->Rect(10,$fpdf->GetY(),190,20,'D');
		$fpdf->MultiCell(190,4,utf8_decode($observacion),0,'J',0);

		$fpdf->SetY(265);
		if(file_exists( public_path().'/images/firmas/'.$firmatrabajador) &&  $firmatrabajador!='' ){
			$fpdf->Image(asset('images/firmas/'.$firmatrabajador),130,252,45,15);
		}
		if(file_exists( public_path().'/images/firmas/'.$firmamedico) &&  $firmamedico!='' ){
			$fpdf->Image(asset('images/firmas/'.$firmamedico),35,252,45,15);
		}
		$fpdf->SetFont('Arial','',9);
		$fpdf->Cell(95,3,'_______________________________',0,0,'C',0);
		$fpdf->Cell(95,3,'_______________________________',0,0,'C',0);
		
		$fpdf->Ln();
		$fpdf->Cell(95,5,$medico,0,0,'C',0);
		$fpdf->Cell(95,5,$trabajador,0,0,'C',0);

		$fpdf->Ln();
		$fpdf->SetFont('Arial','',9);
		$fpdf->Cell(95,3,utf8_decode('Registro Médico ').$registro,0,0,'C',0);
		$fpdf->Cell(95,3,$cedula,0,0,'C',0);
    	$fpdf->Output();
        exit;

    }

    //--------------CONSENTIMIENTO INFORMADO----------------//
	public function consentimiento_informado($historia_ocupacional_id)
	{
		$dia='';
    	$mes='';
    	$anio='';
    	$trabajador='';
    	$empresa='';
    	$cedula='';
    	$cargo='';
    	$edad='';
    	$ocupacion='';
    	$estadocivil='';
    	$genero='';
    	$fechanacimiento='';
		$telefono='';
		$direccion='';

    	$eps='';
    	$afp='';
    	$arl='';
    	$municipio='';
    	$firmatrabajador='';
    	$tipoexamen='';

    	$peso='';
    	$talla='';
    	$imc='';
    	$ta='';
    	$fc='';
    	$fr='';
    	$lateralidad='';
    	$condicion='';
	    $observacion='';
	    $medico='';
	    $registro='';
	    $firmamedico='';
	    $banner='';
	    $recomendaciones='';


		$historia_ocupacional = Historia_ocupacional::where('id',$historia_ocupacional_id)->with('arl')->with('afp')->with('empresa')->with('medico_paciente.paciente.user')->with('medico_paciente.medico.user')->with('ocupacional_actual')->with('condicion_diagnostico')->with('tipo_examen')->with('examen_fisico.lateralidad')->first();
		if(!is_null($historia_ocupacional))
		{

			/*$dia=utf8_decode($historia_ocupacional->created_at->format('d'));
			$mes=utf8_decode($historia_ocupacional->created_at->format('m'));
			$anio=utf8_decode($historia_ocupacional->created_at->format('Y'));*/
			$dia=date('d');
			$mes=date('m');
			$anio=date('Y');

			$mes=$historia_ocupacional->created_at->format('m');
			$anio=$historia_ocupacional->created_at->format('Y');
			$trabajador=$historia_ocupacional->medico_paciente->paciente->user->primerapellido.' '.$historia_ocupacional->medico_paciente->paciente->user->primernombre;
			$empresa=$historia_ocupacional->empresa;
			$cedula=$historia_ocupacional->medico_paciente->paciente->user->tipodocumento.' '.$historia_ocupacional->medico_paciente->paciente->user->numerodocumento;
			$ocupacion=$historia_ocupacional->medico_paciente->paciente->user->ocupacion;
			$estadocivil=$historia_ocupacional->medico_paciente->paciente->user->estadocivil;
			$fechanacimiento=$historia_ocupacional->medico_paciente->paciente->user->fechanacimiento->format('d/m/Y');
			$edad=$historia_ocupacional->medico_paciente->paciente->user->fechanacimiento->diff(Carbon::now())->format('%y años');
			$genero=$historia_ocupacional->medico_paciente->paciente->user->genero;
			$telefono=$historia_ocupacional->medico_paciente->paciente->user->telefono;
			$direccion=$historia_ocupacional->medico_paciente->paciente->user->direccion;
			$municipio=$historia_ocupacional->medico_paciente->paciente->municipio_id;
			if($municipio==0){
				$municipio='N/A';
			}else{
				$municipio_residencia = municipio::where('id',$municipio)->first();
				if(!is_null($municipio_residencia))
				{
					$municipio=$municipio_residencia->descripcion;
				}else{
					$municipio='N/A';
				}
			}

			$cargo=$historia_ocupacional->ocupacional_actual->cargoactual;
			$firmatrabajador=$historia_ocupacional->medico_paciente->paciente->user->firma;
			$query_eps = Empresa::where('id',$historia_ocupacional->empresa_id)->first();
			if(!is_null($query_eps)){ $eps=utf8_decode($query_eps->descripcion);}else{$eps='N/A';}
			$afp=$historia_ocupacional->afp->descripcion;
			$arl=$historia_ocupacional->arl->descripcion;

			$peso=$historia_ocupacional->examen_fisico->peso;
	    	$talla=$historia_ocupacional->examen_fisico->talla;
	    	$imc=$historia_ocupacional->examen_fisico->imc;
	    	$ta=$historia_ocupacional->examen_fisico->ta;
	    	$fc=$historia_ocupacional->examen_fisico->fc;
	    	$fr=$historia_ocupacional->examen_fisico->fr;
	    	$lateralidad=$historia_ocupacional->examen_fisico->lateralidad->descripcion;
			$tipoexamen=utf8_decode($historia_ocupacional->tipo_examen->descripcion);
			$condicion=$historia_ocupacional->condicion_diagnostico->condicion;
	    	$observacion=$historia_ocupacional->condicion_diagnostico->observacion;
	    	
	    	$medico=utf8_decode($historia_ocupacional->medico_paciente->medico->user->primerapellido.' '.$historia_ocupacional->medico_paciente->medico->user->primernombre);
	    	$registro=utf8_decode($historia_ocupacional->medico_paciente->medico->registro);
	    	$firmamedico=utf8_decode($historia_ocupacional->medico_paciente->medico->user->firma);
	    	$banner=utf8_decode($historia_ocupacional->medico_paciente->medico->banner);
	    	$recomendaciones=utf8_decode($historia_ocupacional->recomendaciones);
		}

		$fpdf = new PDF();
        $fpdf->AddPage();
        $fpdf->SetTextColor(0,0,0);
		$fpdf->SetFillColor(255,255,255);


        if(file_exists( public_path().'/images/banner/'.$banner) &&  $banner!='' ){
			$fpdf->Image(asset('images/banner/'.$banner),10,8,190,30);
		}

        $fpdf->AliasNbPages();
        $fpdf->SetY(40);
		$fpdf->SetTitle("Consentimiento");
		$fpdf->SetFont('Arial','B',10);
		$fpdf->Cell(190,6,'CONSENTIMIENTO INFORMADO DE EXAMENES OCUPACIONALES',1,0,'C',0);
		$fpdf->Ln();

		$fpdf->SetFont('Arial','B',9);
		$fpdf->Cell(190,5,'Datos Personales ',1,0,'C',0);
		$fpdf->Ln();

		$fpdf->SetWidths(array(100,55,35));
		$fpdf->SetAligns(array('L','C','C'));
		$fpdf->SetFont('Arial','B',9);
		$fpdf->Row(array('Nombre y Apellido','Documento','Edad'));
		$fpdf->SetFont('Arial','',9);
		$fpdf->Row(array($trabajador,$cedula,$edad));


		$fpdf->SetWidths(array(30,30,30,100));
		$fpdf->SetAligns(array('C','C','C','C'));
		$fpdf->SetFont('Arial','B',9);
		$fpdf->Row(array('Fecha Nac.','Genero','Estado Civil','Ocupacion'));
		$fpdf->SetFont('Arial','',9);
		$fpdf->Row(array($fechanacimiento,$genero,$estadocivil,$ocupacion));


		
		$fpdf->SetWidths(array(30,60,100));
		$fpdf->SetAligns(array('C','C','L'));
		$fpdf->SetFont('Arial','B',9);
		$fpdf->Row(array('Teléfono','Ciudad','Dirección'));
		$fpdf->SetFont('Arial','',9);
		$fpdf->Row(array($telefono,$municipio,$direccion));


		$fpdf->SetFont('Arial','B',9);
		$fpdf->Cell(190,5,'Datos Ocupacionales ',1,0,'C',0);
		$fpdf->Ln();

		$fpdf->SetWidths(array(120,70));
		$fpdf->SetAligns(array('L','C'));
		$fpdf->SetFont('Arial','B',9);
		$fpdf->Row(array('Empresa','Cargo'));
		$fpdf->SetFont('Arial','',9);
		$fpdf->Row(array($empresa,$cargo));

		$fpdf->SetWidths(array(63.3,63.3,63.3));
		$fpdf->SetAligns(array('L','L','L'));
		$fpdf->SetFont('Arial','B',9);
		$fpdf->Row(array('AFP','ARL','EPS'));
		$fpdf->SetFont('Arial','',8);
		$fpdf->Row(array($afp,$arl,$eps));


		$fpdf->Ln();
		$fpdf->SetFont('Arial','',9);
		$fpdf->MultiCell(190,5,utf8_decode('Yo: '.$trabajador.' identificado(a)  No. '.$cedula.' certifico que he sido informado (a) acerca de la naturaleza y proposito de los examenes ocupacionales y para clínicos que la empresa contratante solicita; autorizo sean estos realizados por los profesionales de la empresa CONSULTORIO MEDICO - SALUD OCUPACIONAL - '.$medico.' '),0,'J',0);
		
		$fpdf->Ln();
		$fpdf->SetFont('Arial','B',9);
		$fpdf->Cell(190,5,utf8_decode('EXAMENES'),1,0,'C',0);
		$fpdf->Ln();
		
		$fpdf->SetFont('Arial','B',9);
		$fpdf->Cell(5,6,'',1,0,'C',0);
		$fpdf->Cell(90,6,'Tipo de Examen',1,0,'L',0);
		$fpdf->Cell(5,6,'',1,0,'C',0);
		$fpdf->Cell(90,6,'Tipo de Examen',1,0,'L',0);
		$fpdf->SetFont('Arial','',9);
		$fpdf->Ln();
		$Tipo_consentimientos= Tipo_consentimiento::orderby('id')->get();
		$i=0;
		foreach ( $Tipo_consentimientos as $Tipo_consentimiento ){
			 $Consentimiento=Consentimiento::where(['tipo_consentimiento_id' => $Tipo_consentimiento->id,'historia_ocupacional_id'=> $historia_ocupacional->id ])->first();
			if(is_null($Consentimiento))
			{
				$fpdf->Cell(5,6,'',1,0,'C',0);
			}else{
				$fpdf->Cell(5,6,'X',1,0,'C',0);
			}
			
			$fpdf->Cell(90,6,utf8_decode($Tipo_consentimiento->descripcion),1,0,'L',0);
			if($i%2!=0)
			{
				$fpdf->Ln();	
			}
			$i=$i+1;
		}

		$fpdf->Ln(6);
		$alto=$fpdf->GetY()+35;
		$fpdf->Cell(190,5,'','B',0,'C',0);
		$fpdf->Ln();
		$fpdf->Cell(190,5,'','B',0,'C',0);
		$fpdf->Ln();
		$fpdf->Cell(190,5,'','B',0,'C',0);
		$fpdf->Ln();
		$fpdf->Cell(190,5,'','B',0,'C',0);
		$fpdf->Ln();
		$fpdf->Cell(190,5,'','B',0,'C',0);
		$fpdf->Ln();
		$fpdf->Cell(190,5,'','B',0,'C',0);
		
		$fpdf->Ln(-24);
		$fpdf->SetFont('Arial','',9);
		$fpdf->MultiCell(190,5	,utf8_decode(''),0,'J',0);

		$fpdf->SetY($alto);
		$fpdf->SetFont('Arial','',9);
		$fpdf->MultiCell(190,5	,utf8_decode('Ademas autorizo a CONSULTORIO MEDICO - SALUD OCUPACIONAL '.$medico.',  para que sea enviada una copia de mi historia clinica ocupacional al medico de Salud Ocupacional de la empresa que me contrata'),0,'J',0);
		
		$fpdf->Ln();

		$fpdf->SetY(250);
		if(file_exists( public_path().'/images/firmas/'.$firmatrabajador) &&  $firmatrabajador!='' ){
			$fpdf->Image(asset('images/firmas/'.$firmatrabajador),130,237,45,15);
		}
		if(file_exists( public_path().'/images/firmas/'.$firmamedico) &&  $firmamedico!='' ){
			$fpdf->Image(asset('images/firmas/'.$firmamedico),35,237,45,15);
		}
		$fpdf->SetFont('Arial','',9);

		$fpdf->Cell(95,3,'_______________________________',0,0,'C',0);
		$fpdf->Cell(95,3,'_______________________________',0,0,'C',0);
		
		$fpdf->Ln();
		$fpdf->Cell(95,5,$medico,0,0,'C',0);
		$fpdf->Cell(95,5,$trabajador,0,0,'C',0);

		$fpdf->Ln();
		$fpdf->SetFont('Arial','',9);
		$fpdf->Cell(95,4,utf8_decode('Registro Médico ').$registro,0,0,'C',0);
		$fpdf->SetFont('Arial','',9);
		$fpdf->Cell(95,4,$cedula,0,0,'C',0);
    	$fpdf->Output();
        exit;

	}

//--------------CONCEPTO DE APTITUD LABORAL----------------//
	public function aptitud_laboral($historia_ocupacional_id)
	{
			$dia='';
    	$mes='';
    	$anio='';
    	$trabajador='';
    	$empresa='';
    	$cedula='';
    	$cargo='';
    	$edad='';
    	$ocupacion='';
    	$estadocivil='';
    	$genero='';
    	$fechanacimiento='';
		$telefono='';
		$direccion='';

    	$eps='';
    	$afp='';
    	$arl='';
    	$municipio='';
    	$firmatrabajador='';
    	$tipoexamen='';

    	$peso='';
    	$talla='';
    	$imc='';
    	$ta='';
    	$fc='';
    	$fr='';
    	$lateralidad='';
    	$condicion='';
	    $observacion='';
	    $medico='';
	    $registro='';
	    $firmamedico='';
	    $banner='';
	    $recomendaciones='';


		$historia_ocupacional = Historia_ocupacional::where('id',$historia_ocupacional_id)->with('arl')->with('afp')->with('empresa')->with('medico_paciente.paciente.user')->with('medico_paciente.medico.user')->with('ocupacional_actual')->with('condicion_diagnostico.tipo_condicion')->with('tipo_examen')->with('examen_fisico.lateralidad')->first();
		if(!is_null($historia_ocupacional))
		{

			$mes=$historia_ocupacional->created_at->format('m');
			$anio=$historia_ocupacional->created_at->format('Y');
			$trabajador=$historia_ocupacional->medico_paciente->paciente->user->primerapellido.' '.$historia_ocupacional->medico_paciente->paciente->user->primernombre;
			$empresa=$historia_ocupacional->empresa;
			$cedula=$historia_ocupacional->medico_paciente->paciente->user->tipodocumento.' '.$historia_ocupacional->medico_paciente->paciente->user->numerodocumento;
			$ocupacion=$historia_ocupacional->medico_paciente->paciente->user->ocupacion;
			$estadocivil=$historia_ocupacional->medico_paciente->paciente->user->estadocivil;
			$fechanacimiento=$historia_ocupacional->medico_paciente->paciente->user->fechanacimiento->format('d/m/Y');
			$edad=$historia_ocupacional->medico_paciente->paciente->user->fechanacimiento->diff(Carbon::now())->format('%y años');
			$genero=$historia_ocupacional->medico_paciente->paciente->user->genero;
			$telefono=$historia_ocupacional->medico_paciente->paciente->user->telefono;
			$direccion=$historia_ocupacional->medico_paciente->paciente->user->direccion;
			$municipio=$historia_ocupacional->medico_paciente->paciente->municipio_id;
			if($municipio==0){
				$municipio='N/A';
			}else{
				$municipio_residencia = municipio::where('id',$municipio)->first();
				if(!is_null($municipio_residencia))
				{
					$municipio=$municipio_residencia->descripcion;
				}else{
					$municipio='N/A';
				}
			}

			$cargo=$historia_ocupacional->ocupacional_actual->cargoactual;
			$firmatrabajador=$historia_ocupacional->medico_paciente->paciente->user->firma;
			$query_eps = Empresa::where('id',$historia_ocupacional->empresa_id)->first();
			if(!is_null($query_eps)){ $eps=utf8_decode($query_eps->descripcion);}else{$eps='N/A';}
			$afp=$historia_ocupacional->afp->descripcion;
			$arl=$historia_ocupacional->arl->descripcion;

			$peso=$historia_ocupacional->examen_fisico->peso;
	    	$talla=$historia_ocupacional->examen_fisico->talla;
	    	$imc=$historia_ocupacional->examen_fisico->imc;
	    	$ta=$historia_ocupacional->examen_fisico->ta;
	    	$fc=$historia_ocupacional->examen_fisico->fc;
	    	$fr=$historia_ocupacional->examen_fisico->fr;
	    	$lateralidad=$historia_ocupacional->examen_fisico->lateralidad->descripcion;
			$tipoexamen=utf8_decode($historia_ocupacional->tipo_examen->descripcion);
			$condicion=$historia_ocupacional->condicion_diagnostico->tipo_condicion->descripcion;
	    	$observacion=$historia_ocupacional->condicion_diagnostico->observacion;
	    	
	    	$medico=utf8_decode($historia_ocupacional->medico_paciente->medico->user->primerapellido.' '.$historia_ocupacional->medico_paciente->medico->user->primernombre);
	    	$registro=utf8_decode($historia_ocupacional->medico_paciente->medico->registro);
	    	$firmamedico=utf8_decode($historia_ocupacional->medico_paciente->medico->user->firma);
	    	$banner=utf8_decode($historia_ocupacional->medico_paciente->medico->banner);
	    	$recomendaciones=utf8_decode($historia_ocupacional->recomendaciones);
		}

		$fpdf = new PDF();
        $fpdf->AddPage();
        $fpdf->SetTextColor(0,0,0);
		$fpdf->SetFillColor(255,255,255);

        if(file_exists( public_path().'/images/banner/'.$banner) &&  $banner!='' ){
			$fpdf->Image(asset('images/banner/'.$banner),10,8,190,30);
		}

        $fpdf->AliasNbPages();
        $fpdf->SetY(40);
		$fpdf->SetTitle("Certificado Laboral");
		$fpdf->SetFont('Arial','B',10);
		$fpdf->Cell(190,6,'CONCEPTO DE APTITUD LABORAL',1,0,'C',0);
		$fpdf->Ln();

		$fpdf->SetFont('Arial','B',9);
		$fpdf->Cell(190,5,'Datos Personales ',1,0,'C',0);
		$fpdf->Ln();

		$fpdf->SetWidths(array(100,55,35));
		$fpdf->SetAligns(array('L','C','C'));
		$fpdf->SetFont('Arial','B',9);
		$fpdf->Row(array('Nombre y Apellido','Documento','Edad'));
		$fpdf->SetFont('Arial','',9);
		$fpdf->Row(array($trabajador,$cedula,$edad));


		$fpdf->SetWidths(array(30,30,30,100));
		$fpdf->SetAligns(array('C','C','C','C'));
		$fpdf->SetFont('Arial','B',9);
		$fpdf->Row(array('Fecha Nac.','Genero','Estado Civil','Ocupacion'));
		$fpdf->SetFont('Arial','',9);
		$fpdf->Row(array($fechanacimiento,$genero,$estadocivil,$ocupacion));


		
		$fpdf->SetWidths(array(30,60,100));
		$fpdf->SetAligns(array('C','C','L'));
		$fpdf->SetFont('Arial','B',9);
		$fpdf->Row(array('Teléfono','Ciudad','Dirección'));
		$fpdf->SetFont('Arial','',9);
		$fpdf->Row(array($telefono,$municipio,$direccion));


		$fpdf->SetFont('Arial','B',9);
		$fpdf->Cell(190,5,'Datos Ocupacionales ',1,0,'C',0);
		$fpdf->Ln();

		$fpdf->SetWidths(array(120,70));
		$fpdf->SetAligns(array('L','C'));
		$fpdf->SetFont('Arial','B',9);
		$fpdf->Row(array('Empresa','Cargo'));
		$fpdf->SetFont('Arial','',9);
		$fpdf->Row(array($empresa,$cargo));

		$fpdf->SetWidths(array(63.3,63.3,63.3));
		$fpdf->SetAligns(array('L','L','L'));
		$fpdf->SetFont('Arial','B',9);
		$fpdf->Row(array('AFP','ARL','EPS'));
		$fpdf->SetFont('Arial','',8);
		$fpdf->Row(array($afp,$arl,$eps));

		

		$fpdf->Ln();
		$fpdf->SetFont('Arial','B',8);
		$fpdf->Cell(130,5,utf8_decode('CONCEPTO EXAMEN '.strtoupper($tipoexamen)),1,0,'L',0);
		$fpdf->SetFont('Arial','B',8);
		$fpdf->Cell(60,5,$condicion.'',1,0,'C',0);
		$fpdf->Ln();
		$fpdf->SetFont('Arial','',8);
		$fpdf->Rect(10,$fpdf->GetY(),190,15,'D');
		$fpdf->MultiCell(190,3,utf8_decode(''.$observacion),0,'J',0);

		$fpdf->SetY(124);
		$fpdf->SetFont('Arial','B',8);
		$fpdf->Cell(190,6,utf8_decode('A QUIEN SE LE REALIZARON LOS SIGUIENTES EXAMENES'),1,0,'C',0);
		$fpdf->Ln();

	

		
		
		$ancho=63.33;
		$fpdf->SetFont('Arial','',8);
		$fpdf->Cell($ancho,5,utf8_decode('Examen Médico SO'),1,0,'L',0);
		$i=1;
		$Visual= Visual::where(['historia_ocupacional_id' => $historia_ocupacional->id])->orderBy('id')->get();
		if($Visual->count()>0){
			$fpdf->Cell($ancho,5,utf8_decode('Visiomtría'),1,0,'L',0);
			$i=2;
		}	

		$Traumatologicos = Traumatologico::whereHas('antecedente_ocupacional', function ($query) use ($historia_ocupacional_id){
			    $query->where([	'historia_ocupacional_id' => $historia_ocupacional_id]);
		})->with('lesion')->limit(5)->get();

		$Tipo_organos= Tipo_organo::whereHas('organos.exploraciones', function ($query) use ($historia_ocupacional_id){
			    $query->where([	'exploraciones.historia_ocupacional_id' => $historia_ocupacional_id]);
		})->orderBy('id')->get();

		foreach($Tipo_organos as $Tipo_organo){
			
			if($i%3==0){
				$fpdf->Ln();	
			}
			$fpdf->Cell($ancho,5,utf8_decode($Tipo_organo->descripcion),1,0,'L',0);
			$i=$i+1;
			
		}

		$Examen_laboratorios= Examen_laboratorio::where(['historia_ocupacional_id' => $historia_ocupacional->id])->orderBy('id')->get();
		foreach($Examen_laboratorios as $Examen_laboratorio){
			
			if($i%3==0){
				$fpdf->Ln();	
			}
			$fpdf->Cell($ancho,5,utf8_decode($Examen_laboratorio->examen),1,0,'L',0);
			$i=$i+1;
			
		}

		for($i=$i;$i<24;$i++)
		{
			
			if($i%3==0){
				$fpdf->Ln();	
			}
			$fpdf->Cell($ancho,5,utf8_decode(''),1,0,'L',0);
		}

		$fpdf->Ln();
		$ancho_reco=$fpdf->GetY();
		$fpdf->Ln();
		$fpdf->SetFont('Arial','B',8);
		$fpdf->Cell(190,5,utf8_decode('RECOMENDACIONES MÉDICO LABORAL'),1,0,'C',0);
		$fpdf->Ln();
		$fpdf->Rect(10,$fpdf->GetY(),190,25,'D');
		$fpdf->SetFont('Arial','',8);
		$fpdf->MultiCell(190,4,$recomendaciones,0,'J',0);

		$fpdf->SetY($ancho_reco+40);
/*		$fpdf->SetFont('Arial','',7);
		$fpdf->Rect(10,$fpdf->GetY()-2,190,22,'D');
		$fpdf->MultiCell(190,3,utf8_decode('CONSIDERACIONES LEGALES RELATIVAS A LOS EXAMENES DE INGRESO: Las resoluciones 2346 de 2007 y 1818 de 2009 del Ministerio de la Protección Social actualmente Ministerios de Trabajo y de Salud y Protección Social reglamentan la práctica y contenido de las evaluaciones médicas ocupacionales. Se establece que la empresa solo puede conocer el CERTIFICADO MEDICO DE APTITUD del aspirante.  Los resultados de los exámenes se dan a conocer en el certificado con la autorización del aspirante. Los documentos completos de la Historia Clínica Ocupacional están  sometidos a reserva profesional y quedan bajo nuestra custodia según lo establecido en la Resolución 1918 de 2009. El trabajador puede obtener copia en el momento que lo requiera, entendiendo que hacen parte integral de su historial 
			NOTA: Bajo la gravedad del juramento afirmo que toda la información anteriormente suministrada es correcta y que no he ocultado nada sobre mi historia de salud.'),0,'J',0);
*/

		$fpdf->SetY(245);
		if(file_exists( public_path().'/images/firmas/'.$firmatrabajador) &&  $firmatrabajador!='' ){
			$fpdf->Image(asset('images/firmas/'.$firmatrabajador),130,232,45,15);
		}
		if(file_exists( public_path().'/images/firmas/'.$firmamedico) &&  $firmamedico!='' ){
			$fpdf->Image(asset('images/firmas/'.$firmamedico),35,232,45,15);
		}
		$fpdf->SetFont('Arial','',9);

		$fpdf->Cell(95,3,'_______________________________',0,0,'C',0);
		$fpdf->Cell(95,3,'_______________________________',0,0,'C',0);
		
		$fpdf->Ln();
		$fpdf->Cell(95,5,$medico,0,0,'C',0);
		$fpdf->Cell(95,5,$trabajador,0,0,'C',0);

		$fpdf->Ln();
		$fpdf->SetFont('Arial','',9);
		$fpdf->Cell(95,3,utf8_decode('Registro Médico ').$registro,0,0,'C',0);
		$fpdf->Cell(95,3,$cedula,0,0,'C',0);
    	$fpdf->Output();
        exit;
	}
}