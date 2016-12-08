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
use App\Ginecologia_diagnostico;
use App\Ginecologia_medicamento;
use App\Ginecologia_antecedente;
use App\Ginecologia_incapacidad;
use App\Ginecologia_exploracion_inicial;
use App\Ginecologia_exploracion_periodica;
use App\Ginecologia_exploracion_periodo;
use App\Ginecologia_procedimiento;


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
	public function ginecologia_medicamentos($historia_ginecologica_id)
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
			$trabajador=utf8_decode($historia_ginecologica->medico_paciente->paciente->user->primernombre.' '.$historia_ginecologica->medico_paciente->paciente->user->primerapellido);
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
		
	    	
	    	$medico=utf8_decode($historia_ginecologica->medico_paciente->medico->user->primernombre.' '.$historia_ginecologica->medico_paciente->medico->user->primerapellido);
	    	$registro=utf8_decode($historia_ginecologica->medico_paciente->medico->registro);
	    	$firmamedico=utf8_decode($historia_ginecologica->medico_paciente->medico->user->firma);
	    	$banner=utf8_decode($historia_ginecologica->medico_paciente->medico->banner);
	    	$recomendaciones=utf8_decode($historia_ginecologica->recomendaciones);
		}

		$fpdf = new PDF('L','mm','letter');
        $fpdf->AddPage();
        $fpdf->SetTextColor(0,0,0);
		$fpdf->SetFillColor(255,255,255);
		$fpdf->SetTitle("Indicaciones");

        if(file_exists( public_path().'/images/banner/'.$banner) &&  $banner!='' ){
			$fpdf->Image(asset('images/banner/'.$banner),10,8,120,20);
		}

		if(file_exists( public_path().'/images/banner/'.$banner) &&  $banner!='' ){
			$fpdf->Image(asset('images/banner/'.$banner),150,8,120,20);
		}

		

        
        $fpdf->SetY(40);

        $Ginecologia_medicamentos = Ginecologia_medicamento::where('historia_ginecologica_id',$historia_ginecologica_id)->get();
	
		foreach ($Ginecologia_medicamentos as $Ginecologia_medicamento) {
			$fpdf->SetFont('Arial','',11);
			$fpdf->MultiCell(120,5,utf8_decode($Ginecologia_medicamento->descripcion),0,'L',0);
			$fpdf->Ln(4);
		}

		$fpdf->SetY(40);
		foreach ($Ginecologia_medicamentos as $Ginecologia_medicamento) {
			$fpdf->SetFont('Arial','',10);
			$fpdf->SetX(150);
			$fpdf->MultiCell(120,5,utf8_decode($Ginecologia_medicamento->descripcion.' '.$Ginecologia_medicamento->dosis.' '.$Ginecologia_medicamento->observacion ),0,'L',0);
			$fpdf->Ln(4);
		}
		


		$fpdf->SetY(140);

		if($recomendaciones!=''){
			$fpdf->SetFont('Arial','',10);
			$fpdf->MultiCell(120,5,'Recomendaciones:',0,'L',0);
			$fpdf->Ln(2);
			$fpdf->MultiCell(120,5,$recomendaciones,0,'L',0);
		}
		

	
		$fpdf->SetY(185);
		
		$fpdf->SetFont('Arial','',11);
		$fpdf->MultiCell(120,5,utf8_decode('Médico: '.$medico.' - RM:'.$registro),0,'L',0);

		$fpdf->SetY(185);
		$fpdf->SetX(150);
	
		$fpdf->MultiCell(120,5,utf8_decode('Médico: '.$medico.' - RM:'.$registro),0,'L',0);


		$fpdf->SetY(190);
		
		$fpdf->MultiCell(120,5,utf8_decode('Paciente: '.$trabajador.' - '.$cedula),0,'L',0);
		$fpdf->SetY(190);
		$fpdf->SetX(150);
		
		$fpdf->MultiCell(120,5,utf8_decode('Paciente: '.$trabajador.' - '.$cedula),0,'L',0);



		$fpdf->SetTextColor(255,255,255);
    	$fpdf->Output();
        exit;



	}

//--------------HISTORIA----------------//
    public function historia_ginecologica($historia_ginecologica_id){

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

		$historia_ginecologica = Historia_ginecologica::where('id',$historia_ginecologica_id)->with('medico_paciente.paciente.user')->with('medico_paciente.medico.user')->with('ginecologia_exploracion')->with('medico_paciente.ginecologia_antecedente')->with('medico_paciente.ginecologia_ginecobstetrico')->first();
		if(!is_null($historia_ginecologica))
		{

			$fecha=$historia_ginecologica->created_at->format('d/m/Y');
			
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
			
			
			$peso=$historia_ginecologica->Ginecologia_exploracion->peso;
	    	$talla=$historia_ginecologica->Ginecologia_exploracion->talla;
	    	$pa=$historia_ginecologica->Ginecologia_exploracion->pa;
	    	$ta=$historia_ginecologica->Ginecologia_exploracion->ta;
	    	$fc=$historia_ginecologica->Ginecologia_exploracion->fc;
	    	$fr=$historia_ginecologica->Ginecologia_exploracion->fr;
	    	$aspectogeneral=$historia_ginecologica->Ginecologia_exploracion->aspectogeneral;
	    	$otros=$historia_ginecologica->Ginecologia_exploracion->otros;


	    	$motivo_consulta=$historia_ginecologica->motivo_consulta;
	    	$enfermedad_actual=$historia_ginecologica->enfermedad_actual;
	    	$informe=$historia_ginecologica->informe;
	    	$analisis=$historia_ginecologica->analisis;
	    	
	    	$recomendaciones=$historia_ginecologica->recomendaciones;

	    	 $alergias=$historia_ginecologica->medico_paciente->ginecologia_antecedente->alergias;
	    	 $ingresos=$historia_ginecologica->medico_paciente->ginecologia_antecedente->ingresos;
	    	 $traumatismos=$historia_ginecologica->medico_paciente->ginecologia_antecedente->traumatismos;
	    	 $tratamientos=$historia_ginecologica->medico_paciente->ginecologia_antecedente->tratamientos;
	    	 $hta=$historia_ginecologica->medico_paciente->ginecologia_antecedente->hta;
	    	 $displidemia=$historia_ginecologica->medico_paciente->ginecologia_antecedente->displidemia;
	    	 $dm=$historia_ginecologica->medico_paciente->ginecologia_antecedente->dm;
	    	 $otrosantecedente=$historia_ginecologica->medico_paciente->ginecologia_antecedente->otros;
	    	 $habitos=$historia_ginecologica->medico_paciente->ginecologia_antecedente->habitos;
	    	 $familiares=$historia_ginecologica->medico_paciente->ginecologia_antecedente->familiares;
	    	 $situacion=$historia_ginecologica->medico_paciente->ginecologia_antecedente->situacion;

	    	$gestante=$historia_ginecologica->medico_paciente->ginecologia_ginecobstetrico->gestante;
	    	$fum =$historia_ginecologica->medico_paciente->ginecologia_ginecobstetrico->fum->format('d/m/Y');
	    	$seguridad=$historia_ginecologica->medico_paciente->ginecologia_ginecobstetrico->seguridad;
	    	$cesarias=$historia_ginecologica->medico_paciente->ginecologia_ginecobstetrico->cesarias;
	    	$partos=$historia_ginecologica->medico_paciente->ginecologia_ginecobstetrico->partos;
	    	$abortos=$historia_ginecologica->medico_paciente->ginecologia_ginecobstetrico->abortos;
	    	$gestaciones=$historia_ginecologica->medico_paciente->ginecologia_ginecobstetrico->gestaciones;
	    	$fpp=$historia_ginecologica->medico_paciente->ginecologia_ginecobstetrico->fpp->format('d/m/Y');
		

	       
	    	$medico=utf8_decode($historia_ginecologica->medico_paciente->medico->user->primerapellido.' '.$historia_ginecologica->medico_paciente->medico->user->primernombre);
	    	$registro=utf8_decode($historia_ginecologica->medico_paciente->medico->registro);
	    	$firmamedico=utf8_decode($historia_ginecologica->medico_paciente->medico->user->firma);
	    	$banner=utf8_decode($historia_ginecologica->medico_paciente->medico->banner);



		}
    	
      	$fpdf = new PDF();
        $fpdf->AddPage();
        $fpdf->SetTextColor(0,0,0);
		$fpdf->SetFillColor(255,255,255);
		$letra=8;
        if(file_exists( public_path().'/images/banner/'.$banner) &&  $banner!='' ){
			$fpdf->Image(asset('images/banner/'.$banner),10,8,190,30);
		}

        $fpdf->AliasNbPages();
        $fpdf->SetY(40);
		$fpdf->SetTitle(utf8_decode("Historia Ginecológica"));
		$fpdf->SetFont('Arial','B',$letra);
		$fpdf->Cell(190,5,utf8_decode('HISTORIA GINECOLÓGICA'),1,0,'C',0);
		$fpdf->Ln();

		$fpdf->SetFont('Arial','B',$letra);
		$fpdf->Cell(190,5,'Datos Personales ',1,0,'C',0);
		$fpdf->Ln();

		$fpdf->SetWidths(array(100,55,35));
		$fpdf->SetAligns(array('L','C','C'));
		$fpdf->SetFont('Arial','B',$letra);
		$fpdf->Row(array('Nombre y Apellido','Documento','Edad'));
		$fpdf->SetFont('Arial','',$letra);
		$fpdf->Row(array($trabajador,$cedula,$edad));


		$fpdf->SetWidths(array(30,30,30,100));
		$fpdf->SetAligns(array('C','C','C','C'));
		$fpdf->SetFont('Arial','B',$letra);
		$fpdf->Row(array('Fecha Nac.','Genero','Estado Civil','Ocupacion'));
		$fpdf->SetFont('Arial','',$letra);
		$fpdf->Row(array($fechanacimiento,$genero,$estadocivil,$ocupacion));


		
		$fpdf->SetWidths(array(30,60,100));
		$fpdf->SetAligns(array('C','C','L'));
		$fpdf->SetFont('Arial','B',$letra);
		$fpdf->Row(array('Teléfono','Ciudad','Dirección'));
		$fpdf->SetFont('Arial','',$letra);
		$fpdf->Row(array($telefono,$municipio,$direccion));

		$fpdf->SetFont('Arial','B',$letra);
		$fpdf->Cell(190,5,utf8_decode('NOTA DE INGRESO'),1,0,'C',0);
		$fpdf->Ln();

		
		$fpdf->SetWidths(array(30,160));
		$fpdf->SetAligns(array('C','L'));
		$fpdf->Row(array('Fecha de Ingreso','Origen de la Enfermedad o Accidente'));
		$fpdf->SetFont('Arial','',$letra-1);
		$fpdf->Row(array($fecha,$motivo_consulta));

		$fpdf->CheckPageBreak(15);
		$fpdf->SetFont('Arial','B',$letra);
		$fpdf->Cell(190,5,utf8_decode('ANTECEDENTES'),1,0,'C',0);
		$fpdf->Ln();
		$fpdf->SetFont('Arial','',$letra-1);
		$fpdf->SetWidths(array(190));
		$fpdf->SetAligns(array('L'));
		$fpdf->Row(array('Alergias: '.$alergias));
		$fpdf->Row(array('Ingresos Previos y Cirugias: '.$ingresos));
		$fpdf->Row(array('Traumatismos / Accidentes: '.$traumatismos));
		$fpdf->Row(array('Tratamientos Habituales: '.$tratamientos));

		if($hta==1){$hta='Si';}else{$hta='No';}
		if($displidemia==1){$displidemia='Si';}else{$displidemia='No';}
		if($dm==1){$dm='Si';}else{$dm='No';}
		$fpdf->SetWidths(array(30,8,25,8,20,8,10,81));
		$fpdf->SetAligns(array('L','C','L','C','L','C','L','L'));
		$fpdf->Row(array('Hipertensión Arterial: ',$hta,'Diabetes Mellitus	: ',$dm,'Dislipidemia: ',$displidemia,'Otros: ',$otrosantecedente));

		$fpdf->SetWidths(array(190));
		$fpdf->SetAligns(array('L'));
		$fpdf->Row(array('Habitos Tóxicos: '.$habitos));
		$fpdf->Row(array('Situación Basal (Crónicos): '.$situacion));
		$fpdf->Row(array('Antecedentes familiares de interes: '.$familiares));

		if($gestante==1)
		{
			$gestante='Si';	

		}else{
			$gestante='No';				
			$fpp='N/A';
		}
		if($seguridad==1)
		{
			$seguridad='Si';	

		}else{
			$seguridad='No';				
			
		}
		$fpdf->SetWidths(array(10,15,21,8,15,5,15,5,15,5,17,5,15,8,10,21));
		$fpdf->SetAligns(array('L','C','L','C','L','C','L','C','L','C','L','C','L','C','L','C'));
		$fpdf->Row(array('FUM:',$fum,'Seguridad FUM:',$seguridad,'Cesarias:',$cesarias,'Partos:',$partos,'Abortos:',$abortos,'Gestaciones:',$gestaciones,'Gestante:',$gestante,'FPP:',$fpp));



	   


		$fpdf->CheckPageBreak(15);
		$fpdf->SetFont('Arial','B',$letra);
		$fpdf->Cell(190,5,utf8_decode('ENFERMEDAD ACTUAL'),1,0,'C',0);
		$fpdf->Ln();
		$fpdf->SetFont('Arial','',$letra-1);
		$fpdf->SetWidths(array(190));
		$fpdf->SetAligns(array('L'));
		$fpdf->Row(array($enfermedad_actual));

		$fpdf->CheckPageBreak(15);
		$fpdf->SetFont('Arial','B',$letra);
		$fpdf->Cell(190,5,utf8_decode('ANÁLISIS'),1,0,'C',0);
		$fpdf->Ln();
		$fpdf->SetFont('Arial','',$letra-1);
		$fpdf->SetWidths(array(190));
		$fpdf->SetAligns(array('L'));
		$fpdf->Row(array($analisis));


		$fpdf->CheckPageBreak(15);
		$fpdf->SetFont('Arial','B',$letra);
		$fpdf->Cell(190,5,utf8_decode('DIAGNÓSTICO'),1,0,'C',0);
		$fpdf->Ln();
		$fpdf->SetFont('Arial','B',$letra);
		$fpdf->Cell(15,5,utf8_decode('Código'),1,0,'C',0);
		$fpdf->Cell(75,5,utf8_decode('Diagnóstico'),1,0,'L',0);
		$fpdf->Cell(100,5,utf8_decode('Concepto'),1,0,'L',0);
		$fpdf->Ln();
		$Diagnosticos=Ginecologia_diagnostico::where(['historia_ginecologica_id'=>$historia_ginecologica_id])->with('tipo_diagnostico')->orderby('id')->limit(10)->get();
		$fpdf->SetFont('Arial','',$letra-1);
		$fpdf->SetWidths(array(15,75,100));
		$fpdf->SetAligns(array('C','L','L'));
		if(!is_null($Diagnosticos))
		{
			$i=0;
			foreach ($Diagnosticos as $Diagnostico) {
				$fpdf->Row(array($Diagnostico->tipo_diagnostico->codigo,$Diagnostico->tipo_diagnostico->descripcion,$Diagnostico->concepto));
			}
			
		}

		$fpdf->CheckPageBreak(15);
		$fpdf->SetFont('Arial','B',$letra);
		$fpdf->Cell(190,5,utf8_decode('MEDICAMENTOS'),1,0,'C',0);
		$fpdf->Ln();
		$fpdf->SetFont('Arial','B',$letra);
		$fpdf->Cell(70,5,utf8_decode('Descripción'),1,0,'C',0);
		$fpdf->Cell(50,5,utf8_decode('Dosis'),1,0,'L',0);
		$fpdf->Cell(70,5,utf8_decode('Observación'),1,0,'L',0);
		$fpdf->Ln();
		$Medicamentos=Ginecologia_medicamento::where(['historia_ginecologica_id'=>$historia_ginecologica_id])->orderby('id')->limit(10)->get();
		$fpdf->SetFont('Arial','',$letra-1);
		$fpdf->SetWidths(array(70,50,70));
		$fpdf->SetAligns(array('L','L','L'));
		if(!is_null($Medicamentos))
		{
			$i=0;
			foreach ($Medicamentos as $Medicamento) {
				$fpdf->Row(array($Medicamento->descripcion,$Medicamento->dosis,$Medicamento->observacion));
			}
			
		}

		$fpdf->SetFont('Arial','B',$letra);
		$fpdf->Cell(190,5,utf8_decode('PROCEDIMIENTOS'),1,0,'C',0);
		$fpdf->Ln();
		$fpdf->SetFont('Arial','B',$letra-1);
		$fpdf->Cell(80,5,utf8_decode('Descripción'),1,0,'C',0);
		$fpdf->Cell(110,5,utf8_decode('Observación'),1,0,'C',0);
		$fpdf->Ln();
		$Procedimientos=Ginecologia_procedimiento::where(['historia_ginecologica_id'=>$historia_ginecologica_id])->orderby('id')->limit(10)->get();
		$fpdf->SetFont('Arial','',$letra-1);
		$fpdf->SetWidths(array(80,110));
		$fpdf->SetAligns(array('L','L'));
		if(!is_null($Procedimientos))
		{
			$i=0;
			foreach ($Procedimientos as $Procedimiento) {
				$fpdf->Row(array($Procedimiento->descripcion,$Procedimiento->observacion));
			}
			
		}

		$fpdf->CheckPageBreak(30);
		$fpdf->SetFont('Arial','B',$letra);
		$fpdf->Cell(190,5,utf8_decode('EXPLORACION FÍSICA'),1,0,'C',0);
		$fpdf->Ln();
		$fpdf->SetFont('Arial','B',$letra);
		$fpdf->Cell(10,5,utf8_decode('Peso: '),1,0,'C',0);
		$fpdf->SetFont('Arial','',$letra);
        $fpdf->Cell(20,5,number_format($peso,2).' Kg',1,0,'L',0);
        $fpdf->SetFont('Arial','B',$letra);
		$fpdf->Cell(10,5,utf8_decode('Talla: '),1,0,'L',0);
		$fpdf->SetFont('Arial','',$letra);
		$fpdf->Cell(20,5,number_format($talla,2).' Mts',1,0,'C',0);
		$fpdf->SetFont('Arial','B',$letra);
		$fpdf->Cell(10,5,utf8_decode('PA: '),1,0,'C',0);
		$fpdf->SetFont('Arial','',$letra);
		$fpdf->Cell(20,5,$pa,1,0,'L',0);
		$fpdf->SetFont('Arial','B',$letra);
		$fpdf->Cell(10,5,utf8_decode('TA: '),1,0,'C',0);
		$fpdf->SetFont('Arial','',$letra);
		$fpdf->Cell(20,5,$ta,1,0,'L',0);
		$fpdf->SetFont('Arial','B',$letra);
		$fpdf->Cell(10,5,utf8_decode('FC: '),1,0,'C',0);
		$fpdf->SetFont('Arial','',$letra);
		$fpdf->Cell(20,5,$fc,1,0,'L',0);
		$fpdf->SetFont('Arial','B',$letra);
		$fpdf->Cell(10,5,utf8_decode('FR: '),1,0,'C',0);
		$fpdf->SetFont('Arial','',$letra);
		$fpdf->Cell(30,5,$fr,1,0,'L',0);
		$fpdf->Ln();
		$fpdf->SetFont('Arial','',$letra-1);
		$fpdf->SetWidths(array(190));
		$fpdf->SetAligns(array('L'));
		$fpdf->Row(array('Otros: '.$otros));

		$fpdf->SetWidths(array(190));
		$fpdf->SetAligns(array('L'));
		$fpdf->Row(array('Aspectos General: '.$aspectogeneral));

		$fpdf->CheckPageBreak(15);
		$fpdf->SetFont('Arial','B',$letra);
		$fpdf->Cell(190,5,utf8_decode('INFORME'),1,0,'C',0);
		$fpdf->Ln();
		$fpdf->SetFont('Arial','',$letra-1);
		$fpdf->SetWidths(array(190));
		$fpdf->SetAligns(array('L'));
		$fpdf->Row(array($informe));

		$fpdf->CheckPageBreak(15);
		$fpdf->SetFont('Arial','B',$letra-1);
		$fpdf->Cell(190,5,utf8_decode('RECOMENDACIONES'),1,0,'C',0);
		$fpdf->Ln();
		$fpdf->SetFont('Arial','',$letra);
		$fpdf->SetWidths(array(190));
		$fpdf->SetAligns(array('L'));
		$fpdf->Row(array($recomendaciones));
	

		
	    /*	$aspectogeneral=$historia_ginecologica->Ginecologia_exploracion->aspectogeneral;
	    	$otros=$historia_ginecologica->Ginecologia_exploracion->otros;
*/

		
		$fpdf->CheckPageBreak(45);
		$fpdf->Ln(25);

		if(file_exists( public_path().'/images/firmas/'.$firmatrabajador) &&  $firmatrabajador!='' ){
			$fpdf->Image(asset('images/firmas/'.$firmatrabajador),130,$fpdf->GetY()-12,45,15);
		}
		if(file_exists( public_path().'/images/firmas/'.$firmamedico) &&  $firmamedico!='' ){
			$fpdf->Image(asset('images/firmas/'.$firmamedico),35,$fpdf->GetY()-12,45,15);
		}
		$fpdf->SetFont('Arial','',$letra);
		$fpdf->Cell(95,3,'_______________________________',0,0,'C',0);
		$fpdf->Cell(95,3,'_______________________________',0,0,'C',0);
		
		$fpdf->Ln();
		$fpdf->Cell(95,5,$medico,0,0,'C',0);
		$fpdf->Cell(95,5,$trabajador,0,0,'C',0);

		$fpdf->Ln();
		$fpdf->SetFont('Arial','',$letra);
		$fpdf->Cell(95,3,utf8_decode('Registro Médico ').$registro,0,0,'C',0);
		$fpdf->Cell(95,3,$cedula,0,0,'C',0);
    	$fpdf->Output();
        exit;

    }
	//--------------HISTORIA INDICACIONES----------------//
 	public function historia_ginecologica_indicaciones($historia_ginecologica_id,$tipo)
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
	    	$medico=utf8_decode($historia_ginecologica->medico_paciente->medico->user->primerapellido.' '.$historia_ginecologica->medico_paciente->medico->user->primernombre);
	    	$registro=utf8_decode($historia_ginecologica->medico_paciente->medico->registro);
	    	$firmamedico=utf8_decode($historia_ginecologica->medico_paciente->medico->user->firma);
	    	$banner=utf8_decode($historia_ginecologica->medico_paciente->medico->banner);
	    	$analisis=utf8_decode($historia_ginecologica->analisis);
	    	
	    	$recomendaciones=utf8_decode($historia_ginecologica->recomendaciones);
		}

		$fpdf = new PDF('P','mm','letter');
        $fpdf->AddPage();
   		$fpdf->SetTextColor(0,0,0);
		$fpdf->SetFillColor(255,255,255);
		$letra=8;
        if(file_exists( public_path().'/images/banner/'.$banner) &&  $banner!='' ){
			$fpdf->Image(asset('images/banner/'.$banner),10,8,190,30);
		}

        $fpdf->AliasNbPages();
        $fpdf->SetY(40);
		$fpdf->SetTitle("Historia_Ginecologica");
	     
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

		if($tipo=='analisis')
		{
			$fpdf->Ln(10);
			$fpdf->Rect(10,$fpdf->GetY(),190,100,'D');
			$fpdf->SetFont('Arial','B',9);
			$fpdf->MultiCell(190,5,utf8_decode('ANÁLISIS'),1,'C',0);
			$fpdf->SetFont('Arial','',9);
			$fpdf->MultiCell(190,5,$analisis,0,'J',0);

		}elseif($tipo=='procedimientos'){

		
			$fpdf->SetFont('Arial','B',$letra);
			$fpdf->Cell(190,5,utf8_decode('PROCEDIMIENTOS'),1,0,'C',0);
			$fpdf->Ln();
			$fpdf->SetFont('Arial','B',$letra);
			$fpdf->Cell(80,5,utf8_decode('Descripción'),1,0,'C',0);
			$fpdf->Cell(110,5,utf8_decode('Observación'),1,0,'C',0);
			$fpdf->Ln();
			$Procedimientos=Ginecologia_procedimiento::where(['historia_ginecologica_id'=>$historia_ginecologica_id])->orderby('id')->limit(10)->get();
			$fpdf->SetFont('Arial','',$letra-1);
			$fpdf->SetWidths(array(80,110));
			$fpdf->SetAligns(array('L','L'));
			if(!is_null($Procedimientos))
			{
				$i=0;
				foreach ($Procedimientos as $Procedimiento) {
					$fpdf->Row(array($Procedimiento->descripcion,$Procedimiento->observacion));
				}
				
			}



		}elseif($tipo=='recomendaciones'){

			$fpdf->Ln(10);
			$fpdf->Rect(10,$fpdf->GetY(),190,100,'D');
			$fpdf->SetFont('Arial','B',9);
			$fpdf->MultiCell(190,5,utf8_decode('RECOMENDACIONES'),1,'C',0);
			$fpdf->SetFont('Arial','',9);
			$fpdf->MultiCell(190,5,$recomendaciones,0,'J',0);

		}elseif($tipo=='incapacidad'){

			$Ginecologia_incapacidad = Ginecologia_incapacidad::where('historia_ginecologica_id',$historia_ginecologica_id)->first();
			if(!is_null($Ginecologia_incapacidad)){
				$fecha_inicial=$Ginecologia_incapacidad->fechainicial->format('d/m/Y');
				$fecha_final=$Ginecologia_incapacidad->fechafinal->format('d/m/Y');
				$observacion=$Ginecologia_incapacidad->observacion;
			}else{
				$fecha_inicial='';
				$fecha_final='';
				$observacion='';
			}

			$fpdf->Ln(10);
			
			$fpdf->SetFont('Arial','B',9);
			$fpdf->Cell(190,6,utf8_decode('INCAPACIDAD'),1,0,'C',0);
			$fpdf->Ln();
			$fpdf->Ln();
			$fpdf->Cell(28,6,utf8_decode('Fecha de Inicio'),1,0,'C',0);
			$fpdf->SetFont('Arial','',9);
			$fpdf->Cell(20,6,utf8_decode($fecha_inicial),1,0,'C',0);
			$fpdf->SetFont('Arial','B',9);
			$fpdf->Cell(25,6,utf8_decode('Fecha Final'),1,0,'C',0);
			$fpdf->SetFont('Arial','',9);
			$fpdf->Cell(20,6,utf8_decode($fecha_final),1,0,'C',0);
			$fpdf->Ln();
			$fpdf->Rect(10,$fpdf->GetY(),190,100,'D');
			
			$fpdf->MultiCell(190,5,utf8_decode($observacion),0,'J',0);
		}
	
	
		
		$fpdf->SetY(220);
		if(file_exists( public_path().'/images/firmas/'.$firmamedico) &&  $firmamedico!='' ){
			$fpdf->Image(asset('images/firmas/'.$firmamedico),80,208,45,15);
		}
		$fpdf->SetFont('Arial','',10);
		$fpdf->Cell(190,3,'_______________________________',0,0,'C',0);
		
		
		$fpdf->Ln();
		$fpdf->Cell(190,5,$medico,0,0,'C',0);
		$fpdf->Ln();
		$fpdf->SetFont('Arial','',10);
		$fpdf->Cell(190,3,utf8_decode('Registro Médico ').$registro,0,0,'C',0);
    	$fpdf->Output();
        exit;
	}

	//--------------HISTORIA GESTACIONES----------------//
 	public function historia_ginecologica_gestacion($ginecologia_exploracion_inicial_id)
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

	    $Ginecologia_exploracion_inicial = Ginecologia_exploracion_inicial::where('id',$ginecologia_exploracion_inicial_id)->with('medico_paciente.paciente.user')->with('medico_paciente.medico.user')->first();
		
		if(!is_null($Ginecologia_exploracion_inicial))
		{

			$fecha=$Ginecologia_exploracion_inicial->created_at->format('d/m/Y');
			$trabajador=$Ginecologia_exploracion_inicial->medico_paciente->paciente->user->primerapellido.' '.$Ginecologia_exploracion_inicial->medico_paciente->paciente->user->primernombre;
			$empresa=$Ginecologia_exploracion_inicial->empresa;
			$cedula=$Ginecologia_exploracion_inicial->medico_paciente->paciente->user->tipodocumento.' '.$Ginecologia_exploracion_inicial->medico_paciente->paciente->user->numerodocumento;
			$ocupacion=$Ginecologia_exploracion_inicial->medico_paciente->paciente->user->ocupacion;
			$estadocivil=$Ginecologia_exploracion_inicial->medico_paciente->paciente->user->estadocivil;
			$fechanacimiento=$Ginecologia_exploracion_inicial->medico_paciente->paciente->user->fechanacimiento->format('d/m/Y');
			$edad=$Ginecologia_exploracion_inicial->medico_paciente->paciente->user->fechanacimiento->diff(Carbon::now())->format('%y años');
			$genero=$Ginecologia_exploracion_inicial->medico_paciente->paciente->user->genero;
			$telefono=$Ginecologia_exploracion_inicial->medico_paciente->paciente->user->telefono;
			$direccion=$Ginecologia_exploracion_inicial->medico_paciente->paciente->user->direccion;
			$municipio=$Ginecologia_exploracion_inicial->medico_paciente->paciente->municipio_id;
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
			$firmatrabajador=$Ginecologia_exploracion_inicial->medico_paciente->paciente->user->firma;
	    	$medico=utf8_decode($Ginecologia_exploracion_inicial->medico_paciente->medico->user->primerapellido.' '.$Ginecologia_exploracion_inicial->medico_paciente->medico->user->primernombre);
	    	$registro=utf8_decode($Ginecologia_exploracion_inicial->medico_paciente->medico->registro);
	    	$firmamedico=utf8_decode($Ginecologia_exploracion_inicial->medico_paciente->medico->user->firma);
	    	$banner=utf8_decode($Ginecologia_exploracion_inicial->medico_paciente->medico->banner);

	    	$semanaamenorrea=$Ginecologia_exploracion_inicial->semanaamenorrea;
	    	$sacogestacional=$Ginecologia_exploracion_inicial->sacogestacional;
	    	$formasaco=$Ginecologia_exploracion_inicial->formasaco;
	    	$visualizacionembrion=$Ginecologia_exploracion_inicial->visualizacionembrion;
	    	$numeroembriones=$Ginecologia_exploracion_inicial->numeroembriones;
	    	$actividadmotora=$Ginecologia_exploracion_inicial->actividadmotora;
	    	$actividadcardiaca=$Ginecologia_exploracion_inicial->actividadcardiaca;
	    	$longitud=$Ginecologia_exploracion_inicial->longitud;
	    	$corionanterior=$Ginecologia_exploracion_inicial->corionanterior;
	    	$corionposterior=$Ginecologia_exploracion_inicial->corionposterior;
	    	$corioncervix=$Ginecologia_exploracion_inicial->corioncervix;
	    	$ecocardiagrama=$Ginecologia_exploracion_inicial->ecocardiagrama;
	    	$observaciones=$Ginecologia_exploracion_inicial->observaciones;
	    	$fechaparto=$Ginecologia_exploracion_inicial->fechaparto->format('d/m/Y');
	
		}

		$fpdf = new PDF('P','mm','letter');
        $fpdf->AddPage();
   		$fpdf->SetTextColor(0,0,0);
		$fpdf->SetFillColor(255,255,255);
		$letra=8;
        if(file_exists( public_path().'/images/banner/'.$banner) &&  $banner!='' ){
			$fpdf->Image(asset('images/banner/'.$banner),10,8,190,30);
		}

        $fpdf->AliasNbPages();
        $fpdf->SetY(40);
		$fpdf->SetTitle("Historia_Ginecologica");
	     
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

		$fpdf->Ln();
		$fpdf->SetFont('Arial','B',9);
		$fpdf->MultiCell(190,5,utf8_decode('EXPLORACIÓN INICIAL'),1,'C',0);
		$fpdf->SetFont('Arial','B',9);
		$fpdf->SetWidths(array(25,25,40	,30,25,25,20));
		$fpdf->SetAligns(array('C','C','C','C','C','C','C'));
		$fpdf->Row(array('Fecha','Fecha P. Parto','Semana Amenorrea','Saco Gestacional','Forma de Saco','Visualización','Embriones'));
		$fpdf->SetFont('Arial','',9);
		if($visualizacionembrion!=0){$visualizacionembrion='Si';}else{$visualizacionembrion='No';}
		$fpdf->Row(array($fecha,$fechaparto,$semanaamenorrea,$sacogestacional,$formasaco,$visualizacionembrion,$numeroembriones));

		$fpdf->SetFont('Arial','B',9);
		$fpdf->Cell(95,5,utf8_decode('Actividad Embrionaria'),1,0,'C',0);
		$fpdf->Cell(95,5,utf8_decode('Corion Velloso'),1,0,'C',0);

		if($actividadmotora!=0){$actividadmotora='Si';}else{$actividadmotora='No';}
		if($actividadcardiaca!=0){$actividadcardiaca='Si';}else{$actividadcardiaca='No';}
		if($corionanterior!=0){$corionanterior='Si';}else{$corionanterior='No';}
		if($corionposterior!=0){$corionposterior='Si';}else{$corionposterior='No';}
		if($corioncervix!=0){$corioncervix='Si';}else{$corioncervix='No';}
		$fpdf->Ln();
		$fpdf->SetWidths(array(30,30,35,30,30,35));
		$fpdf->SetAligns(array('C','C','C','C','C','C'));
		$fpdf->Row(array('Actividad Motora','Actividad Cardiaca','Longitud Cefalo-Caudal','Anterior','Posterior','Cubre el Cervix'));
		$fpdf->SetFont('Arial','',9);
		$fpdf->Row(array($actividadmotora,$actividadcardiaca,$longitud,$corionanterior,$corionposterior,$corioncervix));

		$fpdf->SetWidths(array(190));
		$fpdf->SetAligns(array('J'));
		$fpdf->SetFont('Arial','',8);
		$fpdf->Row(array('EG Por Ecografía: '.$ecocardiagrama));
		$fpdf->Row(array('Observaciones: '.$observaciones));

 		
 		$Ginecologia_exploracion_periodicas = Ginecologia_exploracion_periodica::where(['ginecologia_exploracion_inicial_id'=>$ginecologia_exploracion_inicial_id])->with('ginecologia_exploracion_periodo')->get();
 		foreach($Ginecologia_exploracion_periodicas as $ginecologia_exploracion_periodica){
 			$fpdf->Ln();
			$fpdf->CheckPageBreak(60);
 			$fpdf->SetFont('Arial','B',9);
			$fpdf->MultiCell(190,5,utf8_decode('EXPLORACIÓN '.strtoupper($ginecologia_exploracion_periodica->ginecologia_exploracion_periodo->descripcion)),1,'C',0);
			$fpdf->SetFont('Arial','B',9);
			$fpdf->SetWidths(array(35,90));
			$fpdf->SetAligns(array('C','C'));
			$fpdf->Row(array('Fecha',' Semana Amenorrea'));
			$fpdf->SetFont('Arial','',9);
			$fpdf->Row(array($ginecologia_exploracion_periodica->created_at->format('d/m/Y'),$ginecologia_exploracion_periodica->semanaamenorrea));

			$fpdf->SetWidths(array(190));
			$fpdf->SetAligns(array('L',));
			$fpdf->Row(array('Situación Fetal: '.$ginecologia_exploracion_periodica->situacionfetal));

			$fpdf->SetWidths(array(190));
			$fpdf->SetAligns(array('L',));
			$fpdf->Row(array('Dorso: '.$ginecologia_exploracion_periodica->dorso));

			$fpdf->SetWidths(array(20,20,30,25,25,35,35));
			$fpdf->SetAligns(array('C','C','C','C','C','C','C'));
			$fpdf->SetFont('Arial','B',9);
			$fpdf->Row(array('DBP','LF','P-Abdominal','Act. Motora','Act. Cardíaca','Act. Respiratoria','Sem. por Ecografía'));
			$fpdf->SetFont('Arial','',9);
			
			$actividadmotora=$ginecologia_exploracion_periodica->actividadmotora;
			$actividadcardiaca=$ginecologia_exploracion_periodica->actividadcardiaca;
			$actividadrespiratoria=$ginecologia_exploracion_periodica->actividadrespiratoria;

			if($actividadmotora!=0){$actividadmotora='Si';}else{$actividadmotora='No';}
			if($actividadrespiratoria!=0){$actividadrespiratoria='Si';}else{$actividadrespiratoria='No';}
			if($actividadcardiaca!=0){$actividadcardiaca='Si';}else{$actividadcardiaca='No';}

			$fpdf->Row(array($ginecologia_exploracion_periodica->dbp,$ginecologia_exploracion_periodica->lf,$ginecologia_exploracion_periodica->pabdominal,$actividadmotora,$actividadcardiaca,$actividadrespiratoria,$ginecologia_exploracion_periodica->semanaecografia));


			$fpdf->SetWidths(array(95,95));
			$fpdf->SetAligns(array('C','C'));
			$fpdf->SetFont('Arial','B',9);
			$fpdf->Row(array('Localización Placentaria','Madurez'));
			$fpdf->SetAligns(array('L','L'));
			$fpdf->SetFont('Arial','',9);
			$fpdf->Row(array($ginecologia_exploracion_periodica->localizacion,$ginecologia_exploracion_periodica->madurez));

			$fpdf->SetFont('Arial','B',9);
			$fpdf->Cell(190,5,utf8_decode('Liquido Amniotico'),1,0,'C',0);
			$fpdf->Ln();

			$fpdf->SetWidths(array(95,95));
			$fpdf->SetAligns(array('C','C'));
			$fpdf->Row(array('Volumen','Observaciones'));
			$fpdf->SetAligns(array('L','L'));
			$fpdf->SetFont('Arial','',9);
			$fpdf->Row(array($ginecologia_exploracion_periodica->liquidovolumen,$ginecologia_exploracion_periodica->liquidoobservaciones));


 		}
	
	
	
	
		$fpdf->CheckPageBreak(32);
		$fpdf->Ln(20);
		if(file_exists( public_path().'/images/firmas/'.$firmamedico) &&  $firmamedico!='' ){
			$fpdf->Image(asset('images/firmas/'.$firmamedico),80,$fpdf->GetY()-12,45,15);
		}
		$fpdf->SetFont('Arial','',10);
		$fpdf->Cell(190,3,'_______________________________',0,0,'C',0);
		
		
		$fpdf->Ln();
		$fpdf->Cell(190,5,$medico,0,0,'C',0);
		$fpdf->Ln();
		$fpdf->SetFont('Arial','',10);
		$fpdf->Cell(190,3,utf8_decode('Registro Médico ').$registro,0,0,'C',0);
    	$fpdf->Output();
        exit;



	}
}