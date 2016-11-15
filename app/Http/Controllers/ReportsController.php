<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Fpdf;
use Image;
use App\User;
use App\Municipio;
use App\Medico;
use App\Asistente;
use App\Historia_ocupacional;
use Carbon\Carbon;
use App\Paciente;
use App\Medico_paciente;
use App\Escolaridad;
use App\Tipo_examen;
use App\Tipo_factor_riesgo;
use App\Factor_riesgo;
use App\Enfermedad;
use App\Turno;
use App\Actividad;
use App\Tiempo_fumador;
use App\Cantidad_fumador;
use App\Tiempo_licor;
use App\Regularidad_medicamento;
use App\Empresa;
use App\Arl;
use App\Afp;
use App\Diagnostico;
use App\Condicion_diagnostico;
use App\Tipo_diagnostico;
use App\Lateralidad;
use App\Examen_visual;
use App\Tipo_examen_visual;
use App\Ojo;
use App\Tipo_organo;
use App\Organo;
use App\Antecedente_ocupacional;
use App\Examen_laboratorio;
use App\Examen_fisico;
use App\Exploracion;
use App\Visual;
use App\Ocupacional_actual;
use App\Ocupacional_actual_factor_riesgo;
use App\Inmunizacion;
use App\Patologico;
use App\Ginecobstetrica;
use App\Habito_fumador;
use App\Habito_licor;
use App\Habito_medicamento;
use App\Antecedente_ocupacional_factor_riesgo;
use App\Lesion;
use App\Traumatologico;
use App\Condicion_altura;
use App\Tipo_examen_altura;
use App\Examen_altura;

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


class ReportsController extends Controller
{

//--------------HISTORIA----------------//
	public function historia($historia_ocupacional_id)
	{
		
		$dia='';
    	$mes='';
    	$anio='';
    	$dian='';
    	$mesn='';
    	$anion='';
    	$genero='';
    	$estadocivil='';
    	$escolaridad='';
    	$actividad='';
    	$turno='';
    	$trabajador='';
    	$direccion='';
    	$telefono='';
    	$empresa='';
    	$cedula='';
    	$cargo='';
    	$edad='';
    	$eps='';
    	$afp='';
    	$arl='';
    	$numeropersonascargo='';
    	$numerohijos='';
    	$tipoexamen='';
    	$municipio='';
    	$firmatrabajador='';
    	$tipoexamen='';
		$medico='';
    	$registro='';
    	$firmamedico='';
    	$banner='';
    	$recomendaciones='';
    	$fumador='';
    	$tiempofumador='';
    	$cantidadfumador='';
    	$bebedor='';
    	$tiempolicor='';
    	$tipolicor='';
    	$medicamento='';
    	$regularidadmedicamento='';
    	$nombremedicamento='';
    	$peso='';
    	$talla='';
    	$imc='';
    	$ta='';
    	$fc='';
    	$fr='';
    	$lateralidad='';
    	$condicion='';
    	$observacion='';

    	$historia_ocupacional = Historia_ocupacional::where(['id' => $historia_ocupacional_id])->with('arl')->with('afp')->with('empresa')->with('medico_paciente.paciente.user.municipio')->with('medico_paciente.medico.user')->with('ocupacional_actual')->with('condicion_diagnostico')->with('tipo_examen')->with('examen_fisico.lateralidad')->first();
		if(!is_null($historia_ocupacional))
		{
			$dia=utf8_decode($historia_ocupacional->created_at->format('d'));
			$mes=utf8_decode($historia_ocupacional->created_at->format('m'));
			$anio=utf8_decode($historia_ocupacional->created_at->format('Y'));

			$dian=utf8_decode($historia_ocupacional->medico_paciente->paciente->user->fechanacimiento->format('d'));
			$mesn=utf8_decode($historia_ocupacional->medico_paciente->paciente->user->fechanacimiento->format('m'));
			$anion=utf8_decode($historia_ocupacional->medico_paciente->paciente->user->fechanacimiento->format('Y'));
			$genero=$historia_ocupacional->medico_paciente->paciente->user->genero;
			$estadocivil=$historia_ocupacional->medico_paciente->paciente->user->estadocivil;
			$escolaridad_query=Escolaridad::findOrFail($historia_ocupacional->escolaridad_id);$escolaridad=$escolaridad_query->descripcion;
			$query_turno = Turno::findOrFail($historia_ocupacional->ocupacional_actual->turno_id);if(!is_null($query_turno)){ $turno=$query_turno->descripcion;}else{$turno='N/A';}
			$query_actividad = Actividad::findOrFail($historia_ocupacional->ocupacional_actual->actividad_id);if(!is_null($query_actividad)){ $actividad=$query_actividad->descripcion;}else{$actividad='N/A';}
			$trabajador=utf8_decode($historia_ocupacional->medico_paciente->paciente->user->primerapellido.' '.$historia_ocupacional->medico_paciente->paciente->user->segundoapellido.' '.$historia_ocupacional->medico_paciente->paciente->user->primernombre.' '.$historia_ocupacional->medico_paciente->paciente->user->segundonombre);
			$direccion=$historia_ocupacional->medico_paciente->paciente->user->direccion;
			$telefono=$historia_ocupacional->medico_paciente->paciente->user->telefono;
			$empresa=utf8_decode($historia_ocupacional->empresa);
			$cedula=utf8_decode($historia_ocupacional->medico_paciente->paciente->user->tipodocumento.' '.$historia_ocupacional->medico_paciente->paciente->user->numerodocumento);
			$cargo=utf8_decode($historia_ocupacional->ocupacional_actual->cargoactual);
			$edad=utf8_decode($historia_ocupacional->medico_paciente->paciente->user->fechanacimiento->diff(Carbon::now())->format('%y años'));
			$firmatrabajador=utf8_decode($historia_ocupacional->medico_paciente->paciente->user->firma);
			$query_eps = Empresa::findOrFail($historia_ocupacional->empresa_id);if(!is_null($query_eps)){ $eps=utf8_decode($query_eps->descripcion);}else{$eps='N/A';}

			$afp=utf8_decode($historia_ocupacional->afp->descripcion);
			$arl=utf8_decode($historia_ocupacional->arl->descripcion);
			$numeropersonascargo=utf8_decode($historia_ocupacional->numeropersonascargo);
			$numerohijos=utf8_decode($historia_ocupacional->numerohijos);

			$municipio=$historia_ocupacional->medico_paciente->paciente->municipio_id;
			if($municipio==0){
				$municipio='N/A';
			}else{
				$municipio_residencia = municipio::findOrFail($municipio);
				if(!is_null($municipio_residencia))
				{
					$municipio=$municipio_residencia->descripcion;
				}else{
					$municipio='N/A';
				}
			}

			$tipoexamen=$historia_ocupacional->tipo_examen->descripcion;
			$medico=utf8_decode($historia_ocupacional->medico_paciente->medico->user->primerapellido.' '.$historia_ocupacional->medico_paciente->medico->user->primernombre);
	    	$registro=utf8_decode($historia_ocupacional->medico_paciente->medico->registro);
	    	$firmamedico=utf8_decode($historia_ocupacional->medico_paciente->medico->user->firma);
	    	$banner=utf8_decode($historia_ocupacional->medico_paciente->medico->banner);
	    	$recomendaciones=utf8_decode($historia_ocupacional->recomendaciones);

	    	$Habito_licor_query=Habito_licor::where(['historia_ocupacional_id'=>$historia_ocupacional->id])->with('tiempo_licor')->first();
	    	if(!is_null($Habito_licor_query))
	    	{
		    	$bebedor=utf8_decode($Habito_licor_query->descripcion);
		    	$tiempolicor=utf8_decode($Habito_licor_query->tiempo_licor->descripcion);
		    	$tipolicor=utf8_decode($Habito_licor_query->tipolicor);
	    	}
	    	$Habito_fumador_query=Habito_fumador::where(['historia_ocupacional_id'=>$historia_ocupacional->id])->with('tiempo_fumador')->with('cantidad_fumador')->first();
	    	if(!is_null($Habito_fumador_query))
	    	{
	    		$fumador=utf8_decode($Habito_fumador_query->descripcion);
		    	$tiempofumador=utf8_decode($Habito_fumador_query->tiempo_fumador->descripcion);
		    	$cantidadfumador=utf8_decode($Habito_fumador_query->cantidad_fumador->descripcion);
	       	}

	       	$Habito_medicamento=Habito_medicamento::where(['historia_ocupacional_id'=>$historia_ocupacional->id])->with('regularidad_medicamento')->first();
	    	if(!is_null($Habito_medicamento))
	    	{
	    		$medicamento=utf8_decode($Habito_medicamento->descripcion);
		    	$regularidadmedicamento=utf8_decode($Habito_medicamento->regularidad_medicamento->descripcion);
		    	$nombremedicamento=utf8_decode($Habito_medicamento->nombremedicamento);
	       	}

       		$peso=$historia_ocupacional->examen_fisico->peso;
	    	$talla=$historia_ocupacional->examen_fisico->talla;
	    	$imc=$historia_ocupacional->examen_fisico->imc;
	    	$ta=$historia_ocupacional->examen_fisico->ta;
	    	$fc=$historia_ocupacional->examen_fisico->fc;
	    	$fr=$historia_ocupacional->examen_fisico->fr;
	    	$lateralidad=$historia_ocupacional->examen_fisico->lateralidad->descripcion;

	    	$condicion=$historia_ocupacional->condicion_diagnostico->condicion;
    		$observacion=$historia_ocupacional->condicion_diagnostico->observacion;

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
		$fpdf->SetTitle("Historia Clinica Ocupacional");
		$fpdf->SetFont('Arial','B',10);
		$fpdf->Cell(190,6,'HISTORIA CLINICA OCUPACIONAL',1,0,'C',0);
		$fpdf->Ln();
		$alto=5;
		

		$letra=9;
		$fpdf->SetFont('Arial','',$letra-1);
		$fpdf->Cell(25,$alto,'Fecha de Ingreso: ',1,0,'L',0);
		$fpdf->Cell(15,$alto,utf8_decode('Día: ').$dia,1,0,'L',0);
		$fpdf->Cell(15,$alto,'Mes: '.$mes,1,0,'L',0);
		$fpdf->Cell(15,$alto,utf8_decode('Año: ').$anio,1,0,'L',0);
		$fpdf->Cell(120,$alto,utf8_decode('Empresa: ').$empresa,1,0,'L',0);
		$fpdf->Ln();

		$Ingreso='';
		$Egreso='';
		$Reingreso='';
		$Periodico='';
		$Manipulador='';
		$Altura='';
		if($tipoexamen=='Ingreso')
		{
			$Ingreso='X';
		}elseif($tipoexamen=='Egreso'){
			$Egreso='X';
		}elseif($tipoexamen=='Reingreso'){
			$Reingreso='X';
		}elseif($tipoexamen=='Periódico'){
			$Periodico='X';
		}elseif($tipoexamen=='Manipulador de alimentos'){
			$Manipulador='X';
		}elseif($tipoexamen=='Altura'){
			$Altura='X';
		}

		$fpdf->SetFont('Arial','',$letra);
		$fpdf->Cell(25,$alto,'Tipo de Examen ',1,0,'L',0);
		$fpdf->Cell(22,$alto,'Ingreso',1,0,'C',0);
		$fpdf->Cell(5,$alto,$Ingreso,1,0,'C',0);
		$fpdf->Cell(22,$alto,'Egreso',1,0,'C',0);
		$fpdf->Cell(5,$alto,$Egreso,1,0,'C',0);
		$fpdf->Cell(22,$alto,'Reingreso',1,0,'C',0);
		$fpdf->Cell(5,$alto,$Reingreso,1,0,'C',0);
		$fpdf->Cell(22,$alto,utf8_decode('Periódico'),1,0,'C',0);
		$fpdf->Cell(5,$alto,$Periodico,1,0,'C',0);
		$fpdf->Cell(22,$alto,'Altura',1,0,'C',0);
		$fpdf->Cell(5,$alto,$Altura,1,0,'C',0);
		$fpdf->Cell(25,$alto,'M. Alimento',1,0,'C',0);
		$fpdf->Cell(5,$alto,$Manipulador,1,0,'C',0);

		$fpdf->Ln($alto*2);

		$fpdf->SetFont('Arial','B',$letra+1);
		$fpdf->Cell(190,6,utf8_decode('IDENTIFICACIÓN DEL PACIENTE'),1,0,'C',0);
		
		$fpdf->Ln();
		$fpdf->SetFont('Arial','',$letra+1);
		$fpdf->Cell(140,($alto+2),'Nombre: '.$trabajador,1,0,'L',0);
		$fpdf->Cell(50,($alto+2),'ID: '.$cedula,1,0,'L',0);
		$fpdf->Ln();

		$fpdf->SetFont('Arial','',$letra);
		$fpdf->Cell(30,$alto,'Fecha Nacimiento',1,0,'C',0);
		$fpdf->Cell(10,$alto,'Edad',1,0,'C',0);
		$fpdf->Cell(10,$alto,'Sexo',1,0,'C',0);
		$fpdf->Cell(40,$alto,'Estado Civil',1,0,'C',0);	
		$fpdf->Cell(100,$alto,'Estudios',1,0,'C',0);	
		$fpdf->Ln();


		$fpdf->Cell(10,$alto,utf8_decode('Día'),1,0,'C',0);
		$fpdf->Cell(10,$alto,'Mes',1,0,'C',0);
		$fpdf->Cell(10,$alto,utf8_decode('Año'),1,0,'C',0);
		$fpdf->Cell(10,$alto,'',0,0,'C',0);
		$fpdf->Cell(5,$alto,'M',1,0,'C',0);
		$fpdf->Cell(5,$alto,'F',1,0,'C',0);
		$fpdf->Cell(8,$alto,'So',1,0,'C',0);	
		$fpdf->Cell(8,$alto,'Ca',1,0,'C',0);	
		$fpdf->Cell(8,$alto,'Di',1,0,'C',0);	
		$fpdf->Cell(8,$alto,'UL',1,0,'C',0);	
		$fpdf->Cell(8,$alto,'Vi',1,0,'C',0);	
		$fpdf->Cell(17,$alto,'Analfabeta',1,0,'C',0);	
		$fpdf->Cell(17,$alto,'Primaria',1,0,'C',0);	
		$fpdf->Cell(17,$alto,'Secundaria',1,0,'C',0);	
		$fpdf->Cell(17,$alto,utf8_decode('Tecnólogo'),1,0,'C',0);	
		$fpdf->Cell(13,$alto,utf8_decode('Técnico'),1,0,'C',0);	
		$fpdf->Cell(19,$alto,utf8_decode('Universitaria'),1,0,'C',0);	
		$fpdf->Ln();

		$m='';
		$f='';
		if($genero=='Masculino'){
			$m='X';
		}elseif($genero=='Femenino'){
			$f='X';
		}
		
		$so='';
		$ca='';
		$di='';
		$vi='';
		$ul='';
		if($estadocivil=='Soltero/a'){
			$so='X';
		}elseif($estadocivil=='Casado/a'){
			$ca='X';
		}elseif($estadocivil=='Divorciado/a'){
			$di='X';
		}elseif($estadocivil=='Viudo/a'){
			$vi='X';
		}elseif($estadocivil=='Union Libre'){
			$ul='X';
		}

		$Analfabeta	= '';
		$Primaria= '';
		$Secundaria= '';
		$Tecnologo= '';
		$Tecnico= '';
		$Universitaria= '';

		if($escolaridad=='Analfabeta'){
			$Analfabeta	= 'X';
		}elseif($escolaridad=='Primaria'){
			$Primaria	= 'X';
		}elseif($escolaridad=='Secundaria'){
			$Secundaria	= 'X';
		}elseif($escolaridad=='Tecnólogo'){
			$Tecnologo	= 'X';
		}elseif($escolaridad=='Técnico'){
			$Tecnico	= 'X';
		}elseif($escolaridad=='Universitaria'){
			$Universitaria	= 'X';
		}	

		$fpdf->Cell(10,$alto,$dian,1,0,'C',0);
		$fpdf->Cell(10,$alto,$mesn,1,0,'C',0);
		$fpdf->Cell(10,$alto,$anion,1,0,'C',0);
		$fpdf->Cell(10,$alto,'',0,0,'C',0);
		$fpdf->Cell(5,$alto,$m,1,0,'C',0);
		$fpdf->Cell(5,$alto,$f,1,0,'C',0);
		$fpdf->Cell(8,$alto,$so,1,0,'C',0);	
		$fpdf->Cell(8,$alto,$ca,1,0,'C',0);	
		$fpdf->Cell(8,$alto,$di,1,0,'C',0);	
		$fpdf->Cell(8,$alto,$ul,1,0,'C',0);	
		$fpdf->Cell(8,$alto,$vi,1,0,'C',0);	
		$fpdf->Cell(17,$alto,$Analfabeta,1,0,'C',0);	
		$fpdf->Cell(17,$alto,$Primaria,1,0,'C',0);	
		$fpdf->Cell(17,$alto,$Secundaria,1,0,'C',0);	
		$fpdf->Cell(17,$alto,$Tecnologo,1,0,'C',0);	
		$fpdf->Cell(13,$alto,$Tecnico,1,0,'C',0);	
		$fpdf->Cell(19,$alto,$Universitaria,1,0,'C',0);
		$fpdf->Ln();

		

		$fpdf->SetFont('Arial','',$letra);
		$fpdf->SetWidths(array(20,20,50,50,50));
		$fpdf->SetAligns(array('C','C','C','C','C'));
		$fpdf->Row(array('No Hijos','A. Cargo','EPS','ARL','AFP'));
		$fpdf->SetFont('Arial','',$letra-1);
		$fpdf->Row(array($numerohijos,$numeropersonascargo,$eps,$arl,$afp));


		$fpdf->SetFont('Arial','',$letra);
		$fpdf->SetWidths(array(100,60,30));
		$fpdf->SetAligns(array('L','C','C'));
		$fpdf->Row(array('Dirección','Ciudad','Teléfono'));
		$fpdf->SetFont('Arial','',$letra);
		$fpdf->Row(array($direccion,$municipio,$telefono));
		

		$fpdf->Ln($alto);

		$fpdf->SetFont('Arial','B',$letra+1);
		$fpdf->Cell(190,6,utf8_decode('ANTECEDENTES OCUPACIONALES'),1,0,'C',0);
		$fpdf->Ln();		

		$fpdf->SetFont('Arial','B',$letra);
		$fpdf->Cell(100,$alto,utf8_decode('Empresa'),1,0,'C',0);
		$fpdf->Cell(60,$alto,utf8_decode('Ocupación'),1,0,'C',0);
		$fpdf->Cell(30,$alto,utf8_decode('Tiempo de Servicio'),1,0,'C',0);
		$fpdf->Ln();

		$Antecedente_ocupacionales = Antecedente_ocupacional::where(['historia_ocupacional_id' => $historia_ocupacional_id])->orderby('id','DESC')->limit(5)->get();
		$i=0;
		$fpdf->SetFont('Arial','',$letra);
		$fpdf->SetWidths(array(100,60,30));
		$fpdf->SetAligns(array('L','C','C'));
		foreach ($Antecedente_ocupacionales as $antecedente_ocupacional) {
			
			$fpdf->Row(array($antecedente_ocupacional->empresa,$antecedente_ocupacional->ocupacion,$antecedente_ocupacional->tiemposervicio));
			$i=$i+1;
		}
		for($i=$i; $i<5;$i++){
			$fpdf->Row(array('','',''));
		}
		$fpdf->Ln();

		$fpdf->SetFont('Arial','B',$letra);
		$fpdf->Cell(190,$alto,utf8_decode('Factores de Riesgos'),1,0,'C',0);
		$fpdf->Ln();
		$array_observaciones=array();
		$alto_columna=38;
 		$ancho_tabla=190;
        $fpdf->SetFont('Arial','B',$letra-1);
        $Tipo_factor_riesgos=Tipo_factor_riesgo::orderby('id')->withCount('factor_riesgos');
        $cantidades=$Tipo_factor_riesgos->pluck('factor_riesgos_count');
		$anchocolumna=$ancho_tabla/$cantidades->sum();
		$arrayaux=array();
		$anchocolumnas= $cantidades->transform(function ($item, $key) use($anchocolumna) {return $item * $anchocolumna;});
		$fpdf->SetWidths($anchocolumnas);
		$fpdf->SetAligns(array('C','C','C','C','C','C','C'));
		$fpdf->Row($Tipo_factor_riesgos->pluck('descripcion'));
 		$fpdf->SetFont('Arial','',$letra-2);
		$Tipo_factor_riesgos=$Tipo_factor_riesgos->get();
		if(!is_null($Tipo_factor_riesgos))
		{
			$margen=10;
			foreach ($Tipo_factor_riesgos as $Tipo_factor_riesgo) {
				$Factor_riesgos=Factor_riesgo::where(['tipo_factor_riesgo_id' => $Tipo_factor_riesgo->id])->orderby('tipo_factor_riesgo_id')->get();
				foreach ($Factor_riesgos as $Factor_riesgo) {
					$fpdf->Rect($margen,$fpdf->GetY(),$anchocolumna,$alto_columna,'D');
					$fpdf->RotatedText($margen+3,$fpdf->GetY()+($alto_columna-1),utf8_decode($Factor_riesgo->descripcion),90);
					$margen=$margen+$anchocolumna;
					$fpdf->SetY($fpdf->GetY()+$alto_columna);
					$fpdf->SetX($margen-$anchocolumna);
					$Antecedente_ocupacional_factor_riesgo = Antecedente_ocupacional_factor_riesgo::where(['factor_riesgo_id' => $Factor_riesgo->id])->
					whereHas('antecedente_ocupacional', function ($query) use ($historia_ocupacional_id){
					    $query->where([	'historia_ocupacional_id' => $historia_ocupacional_id]);
					})->first();
					if(is_null($Antecedente_ocupacional_factor_riesgo)){
						$fpdf->Cell($anchocolumna,$alto,'',1,0,'C',0);	
					}else{
						$fpdf->Cell($anchocolumna,$alto,'X',1,0,'C',0);	
						$texto=$Factor_riesgo->descripcion.': ';
						if($Antecedente_ocupacional_factor_riesgo->tiempoexposicion!='')
						{
							$texto=$texto.' tiempo de exposición '.$Antecedente_ocupacional_factor_riesgo->tiempoexposicion;
						}
						if($Antecedente_ocupacional_factor_riesgo->medidacontrol!='')
						{
							$texto=$texto.' medidas de control '.$Antecedente_ocupacional_factor_riesgo->medidacontrol;
						}
						$array_observaciones[]=$texto;
					}
					$fpdf->SetY($fpdf->GetY()-$alto_columna);
				}
			}
		}
		$fpdf->SetY($fpdf->GetY()+$alto_columna);
		$fpdf->Ln();
		$fpdf->SetFont('Arial','B',$letra);
		$fpdf->Cell(190,$alto,utf8_decode('Observaciones'),1,0,'C',0);
		$fpdf->Ln();
		$fpdf->SetFont('Arial','',$letra-1);
		$texto=implode(' | ', $array_observaciones);
		$fpdf->MultiCell(190,$alto-1,utf8_decode($texto),1,'J',0);

		$fpdf->CheckPageBreak($alto*7);

		$fpdf->SetFont('Arial','B',$letra);
		$fpdf->Cell(190,$alto,utf8_decode('Lesiones'),1,0,'C',0);
		$fpdf->Ln();

		$fpdf->SetFont('Arial','B',$letra);
		$fpdf->Cell(20,$alto,utf8_decode('Lesión'),1,0,'C',0);
		$fpdf->Cell(60,$alto,utf8_decode('Secuela'),1,0,'C',0);
		$fpdf->Cell(70,$alto,utf8_decode('Empresa'),1,0,'C',0);
		$fpdf->Cell(40,$alto,utf8_decode('Arl'),1,0,'C',0);
		$fpdf->Ln();
		$fpdf->SetFont('Arial','',$letra-1);
		$Traumatologicos = Traumatologico::whereHas('antecedente_ocupacional', function ($query) use ($historia_ocupacional_id){
			    $query->where([	'historia_ocupacional_id' => $historia_ocupacional_id]);
		})->with('lesion')->limit(5)->get();
		$array_traumatologico=array();	
		$i=0;
		$fpdf->SetWidths(array(20,60,70,40));
		$fpdf->SetAligns(array('L','L','L','L'));
		foreach ($Traumatologicos as $traumatologico) {
			$fpdf->Row(array($traumatologico->lesion->descripcion,$traumatologico->secuela,$traumatologico->antecedente_ocupacional->empresa,$traumatologico->arl));
			$i=$i+1;
		}
		for($i=$i; $i<5;$i++){
			$fpdf->Row(array('','','','',));
		}

		$fpdf->Ln();
		$fpdf->CheckPageBreak($alto*4+6);

		$fpdf->SetFont('Arial','B',$letra+1);
		$fpdf->Cell(190,6,utf8_decode('INFORMACIÓN OCUPACIONAL ACTUAL'),1,0,'C',0);
		$fpdf->Ln();		

		$fpdf->SetFont('Arial','B',$letra);
		$fpdf->Cell(120,$alto,utf8_decode('Empresa'),1,0,'L',0);
		$fpdf->Cell(70,$alto,utf8_decode('Cargo'),1,0,'L',0);
		$fpdf->Ln();

		$fpdf->SetFont('Arial','',$letra);
		$fpdf->Cell(120,$alto,$empresa,1,0,'L',0);
		$fpdf->Cell(70,$alto,$cargo,1,0,'C',0);
		$fpdf->Ln();

		$fpdf->SetFont('Arial','B',$letra);
		$fpdf->Cell(94,$alto,utf8_decode('Turno'),1,0,'C',0);
		$fpdf->Cell(96,$alto,utf8_decode('Actividad Realizada'),1,0,'C',0);
		$fpdf->Ln();

		$Diurno='';
		$Nocturno='';
		$Rotario='';

		if($turno=='Diurno'){
			$Diurno='X';
		}elseif($turno=='Nocturno'){
			$Nocturno='X';
		}elseif($turno=='Rotario'){
			$Rotario='X';
		}

		$Sentado='';
		$Parado='';
		$Deambulando='';
		if($actividad=='Sentado'){
			$Sentado='X';
		}elseif($actividad=='Parado'){
			$Parado='X';
		}elseif($actividad=='Deambulando'){
			$Deambulando='X';
		}

		$fpdf->SetFont('Arial','',$letra);
		$fpdf->Cell(25,$alto,utf8_decode('Diurno'),1,0,'C',0);
		$fpdf->Cell(5,$alto,$Diurno,1,0,'C',0);
		$fpdf->Cell(27,$alto,utf8_decode('Nocturno'),1,0,'C',0);
		$fpdf->Cell(5,$alto,$Nocturno,1,0,'C',0);
		$fpdf->Cell(27,$alto,utf8_decode('Rotario'),1,0,'C',0);
		$fpdf->Cell(5,$alto,$Rotario,1,0,'C',0);
		$fpdf->Cell(27,$alto,utf8_decode('Sentado'),1,0,'C',0);
		$fpdf->Cell(5,$alto,$Sentado,1,0,'C',0);
		$fpdf->Cell(27,$alto,utf8_decode('Parado'),1,0,'C',0);
		$fpdf->Cell(5,$alto,$Parado,1,0,'C',0);
		$fpdf->Cell(27,$alto,utf8_decode('Deambulando'),1,0,'C',0);
		$fpdf->Cell(5,$alto,$Deambulando,1,0,'C',0);
		$fpdf->Ln();

		$fpdf->CheckPageBreak($alto*2+38);
	
		$fpdf->SetFont('Arial','B',$letra);
		$fpdf->Cell(190,$alto,utf8_decode('Factores de Riesgos'),1,0,'C',0);
		$fpdf->Ln();
		$array_observaciones=array();
		$alto_columna=38;
 		$ancho_tabla=190;
        $fpdf->SetFont('Arial','B',$letra-1);
        $Tipo_factor_riesgos=Tipo_factor_riesgo::orderby('id')->withCount('factor_riesgos');
        $cantidades=$Tipo_factor_riesgos->pluck('factor_riesgos_count');
		$anchocolumna=$ancho_tabla/$cantidades->sum();
		$arrayaux=array();
		$anchocolumnas= $cantidades->transform(function ($item, $key) use($anchocolumna) {return $item * $anchocolumna;});
		$fpdf->SetWidths($anchocolumnas);
		$fpdf->SetAligns(array('C','C','C','C','C','C','C'));
		$fpdf->Row($Tipo_factor_riesgos->pluck('descripcion'));
 		$fpdf->SetFont('Arial','',$letra-2);
		$Tipo_factor_riesgos=$Tipo_factor_riesgos->get();
		if(!is_null($Tipo_factor_riesgos))
		{
			$margen=10;
			foreach ($Tipo_factor_riesgos as $Tipo_factor_riesgo) {
				$Factor_riesgos=Factor_riesgo::where(['tipo_factor_riesgo_id' => $Tipo_factor_riesgo->id])->orderby('tipo_factor_riesgo_id')->get();
				foreach ($Factor_riesgos as $Factor_riesgo) {
					$fpdf->Rect($margen,$fpdf->GetY(),$anchocolumna,$alto_columna,'D');
					$fpdf->RotatedText($margen+3,$fpdf->GetY()+($alto_columna-1),utf8_decode($Factor_riesgo->descripcion),90);
					$margen=$margen+$anchocolumna;
					$fpdf->SetY($fpdf->GetY()+$alto_columna);
					$fpdf->SetX($margen-$anchocolumna);
					$Ocupacional_actual_factor_riesgo = Ocupacional_actual_factor_riesgo::where(['factor_riesgo_id' => $Factor_riesgo->id])->
					whereHas('ocupacional_actual', function ($query) use ($historia_ocupacional_id){
					    $query->where([	'historia_ocupacional_id' => $historia_ocupacional_id]);
					})->first();
					if(is_null($Ocupacional_actual_factor_riesgo)) {
						$fpdf->Cell($anchocolumna,$alto,'',1,0,'C',0);	
					}else{
						$fpdf->Cell($anchocolumna,$alto,'X',1,0,'C',0);	
						$texto=$Factor_riesgo->descripcion.': ';
						if($Ocupacional_actual_factor_riesgo->tiempoexposicion!='')
						{
							$texto=$texto.' tiempo de exposición '.$Ocupacional_actual_factor_riesgo->tiempoexposicion;
						}
						if($Ocupacional_actual_factor_riesgo->medidacontrol!='')
						{
							$texto=$texto.' medidas de control '.$Ocupacional_actual_factor_riesgo->medidacontrol;
						}
						$array_observaciones[]=$texto;
					}
					$fpdf->SetY($fpdf->GetY()-$alto_columna);
				}
			}
		}
		$fpdf->SetY($fpdf->GetY()+$alto_columna);
		$fpdf->Ln();
		$fpdf->SetFont('Arial','B',$letra);
		$fpdf->Cell(190,$alto,utf8_decode('Observaciones'),1,0,'C',0);
		$fpdf->Ln();
		$fpdf->SetFont('Arial','',$letra-1);
		$texto=implode(' | ', $array_observaciones);
		$fpdf->MultiCell(190,$alto-1,utf8_decode($texto),1,'J',0);

		

		$fpdf->Ln($alto);
		$fpdf->SetFont('Arial','B',$letra+1);
		$fpdf->Cell(190,6,utf8_decode('ANTECEDENTES'),1,0,'C',0);

		$fpdf->Ln();
		$fpdf->SetFont('Arial','B',$letra);
		$fpdf->Cell(190,$alto,utf8_decode('Habitos'),1,0,'C',0);
		$fpdf->Ln();

		$fpdf->SetFont('Arial','',$letra);
		$fpdf->Cell(20,$alto,utf8_decode('Fumador'),1,0,'C',0);
		$fpdf->Cell(25,$alto,utf8_decode('Tiempo'),1,0,'C',0);
		$fpdf->Cell(35,$alto,utf8_decode('Cantidad'),1,0,'C',0);

		$fpdf->Cell(20,$alto,utf8_decode('Bebedor'),1,0,'C',0);
		$fpdf->Cell(25,$alto,utf8_decode('Tiempo'),1,0,'C',0);
		$fpdf->Cell(65,$alto,utf8_decode('Tipo de licor'),1,0,'C',0);
		$fpdf->Ln();

		$fpdf->Cell(20,$alto,$fumador,1,0,'C',0);
		$fpdf->Cell(25,$alto,$tiempofumador,1,0,'C',0);
		$fpdf->Cell(35,$alto,$cantidadfumador,1,0,'C',0);

		$fpdf->Cell(20,$alto,$bebedor,1,0,'C',0);
		$fpdf->Cell(25,$alto,$tiempolicor,1,0,'C',0);
		$fpdf->Cell(65,$alto,$tipolicor,1,0,'L',0);
		$fpdf->Ln();

		$fpdf->Cell(60,$alto,utf8_decode('¿Consume Medicamento Psicoactivo?'),1,0,'L',0);
		$fpdf->Cell(130,$alto,utf8_decode('¿Cual?'),1,0,'C',0);
		$fpdf->Ln();

		$fpdf->Cell(60,$alto,$regularidadmedicamento,1,0,'L',0);
		$fpdf->Cell(130,$alto,$nombremedicamento,1,0,'L',0);
		$fpdf->Ln();

		
		$fpdf->SetFont('Arial','B',$letra);
		$fpdf->Cell(190,$alto,utf8_decode('Patológicos Personales y Familiares'),1,0,'C',0);
		$fpdf->Ln();

		$fpdf->SetFont('Arial','B',$letra-1);
		for($i=0; $i<4;$i++){
			
			$fpdf->Cell(37.5,$alto,utf8_decode('Enfermedad'),1,0,'C',0);
			$fpdf->Cell(5,$alto,utf8_decode('P'),1,0,'C',0);
			$fpdf->Cell(5,$alto,utf8_decode('F'),1,0,'C',0);
		}
		$fpdf->Ln();
		$i=0;
		$fpdf->SetFont('Arial','',$letra-2);
		$Enfermedades=Enfermedad::orderby('id')->get();
		if(!is_null($Enfermedades))
		{
			
			foreach ($Enfermedades as $Enfermedad) {
				$i=$i+1;
				$fpdf->Cell(37.5,$alto-1,utf8_decode($Enfermedad->descripcion),1,0,'L',0);
				$Patologico=Patologico::where(['enfermedad_id' => $Enfermedad->id, 'historia_ocupacional_id' => $historia_ocupacional_id])->orderby('id')->first();
				$familiar='';
				$personal='';
				if(!is_null($Patologico)){
					if($Patologico->familiar==1){$familiar='X';}	
					if($Patologico->personal==1){$personal='X';}	
				}
				
				$fpdf->Cell(5,$alto-1,$personal,1,0,'C',0);
				$fpdf->Cell(5,$alto-1,$familiar,1,0,'C',0);
				if( $i%4 == 0){
					$fpdf->Ln();	
				}
			}
			while($i%4 != 0){
				$i=$i+1;
				$fpdf->Cell(37.5,$alto-1,utf8_decode(''),1,0,'L',0);
				$fpdf->Cell(5,$alto-1,utf8_decode(''),1,0,'C',0);
				$fpdf->Cell(5,$alto-1,utf8_decode(''),1,0,'C',0);
			}
		}
		$fpdf->Ln();

		$fpdf->SetFont('Arial','B',$letra);
		$fpdf->Cell(190,$alto,utf8_decode('Inmunizaciones'),1,0,'C',0);
		$fpdf->Ln();

		$fpdf->SetFont('Arial','B',$letra-1);
		for($i=0; $i<2;$i++){
			
			$fpdf->Cell(30,$alto,utf8_decode('Vacuna'),1,0,'C',0);
			$fpdf->Cell(20,$alto,utf8_decode('Fecha'),1,0,'C',0);
			$fpdf->Cell(45,$alto,utf8_decode('Dosis'),1,0,'C',0);
		}
		$fpdf->Ln();
		$i=0;
		$fpdf->SetFont('Arial','',$letra-2);
		$Inmunizaciones=Inmunizacion::where(['historia_ocupacional_id' => $historia_ocupacional_id])->limit(16)->get();
		if(!is_null($Inmunizaciones))
		{
			
			foreach ($Inmunizaciones as $Inmunizacion) {
				
				$fpdf->Cell(30,$alto-1,utf8_decode($Inmunizacion->vacuna),1,0,'L',0);
				$fpdf->Cell(20,$alto-1,utf8_decode($Inmunizacion->fecha->format('d-m-Y')),1,0,'C',0);
				$fpdf->Cell(45,$alto-1,utf8_decode($Inmunizacion->dosis),1,0,'L',0);
				if( $i%2 != 0){
					$fpdf->Ln();	
				}
				$i=$i+1;
			}
			for($i=$i; $i<16;$i++){
				
				$fpdf->Cell(30,$alto-1,utf8_decode(''),1,0,'L',0);
				$fpdf->Cell(20,$alto-1,utf8_decode(''),1,0,'C',0);
				$fpdf->Cell(45,$alto-1,utf8_decode(''),1,0,'C',0);
				if( $i%2 != 0){
					$fpdf->Ln();
				}
				
			}
		}
		
		$Ginecobstetrica = Ginecobstetrica::where(['historia_ocupacional_id'=> $historia_ocupacional->id])->first();
        if($Ginecobstetrica)
        {
        	$fpdf->SetFont('Arial','B',$letra);
			$fpdf->Cell(190,$alto,utf8_decode('Ginecobstétrica '),1,0,'C',0);
			$fpdf->Ln();
			$fpdf->SetFont('Arial','',$letra);
        	$fum=$Ginecobstetrica->fum->format('d/m/y');
            $fuc=$Ginecobstetrica->fuc->format('d/m/y');
            $citologia=utf8_decode($Ginecobstetrica->citologia);
            $dismenorrea=$Ginecobstetrica->dismenorrea;
            $gravidez=$Ginecobstetrica->gravidez;
            $partos=$Ginecobstetrica->partos;
            $cesarias=$Ginecobstetrica->cesarias;
            $abortos=$Ginecobstetrica->abortos;

        	$fpdf->Cell(30,$alto-1,utf8_decode('FUM: ').$fum,1,0,'L',0);
			$fpdf->Cell(30,$alto-1,utf8_decode('FUC: ').$fuc,1,0,'L',0);
			$fpdf->Cell(130,$alto-1,utf8_decode('Citología: ').$citologia,1,0,'L',0);
            $fpdf->Ln();

            $fpdf->Cell(25,$alto-1,utf8_decode('Dismenrrea: '),1,0,'C',0);
            $fpdf->Cell(5,$alto-1,$dismenorrea,1,0,'C',0);
			$fpdf->Cell(35,$alto-1,utf8_decode('Gravidez: '),1,0,'C',0);
			$fpdf->Cell(5,$alto-1,$gravidez,1,0,'C',0);
			$fpdf->Cell(35,$alto-1,utf8_decode('Partos: '),1,0,'C',0);
			$fpdf->Cell(5,$alto-1,$partos,1,0,'C',0);
			$fpdf->Cell(35,$alto-1,utf8_decode('Cesarias: '),1,0,'C',0);
			$fpdf->Cell(5,$alto-1,$partos,1,0,'C',0);
			$fpdf->Cell(35,$alto-1,utf8_decode('Abortos: '),1,0,'C',0);
			$fpdf->Cell(5,$alto-1,$partos,1,0,'C',0);
            $fpdf->Ln();
           
        }

        $fpdf->CheckPageBreak($alto*4+35);

        $fpdf->SetFont('Arial','B',$letra);
		$fpdf->Cell(190,$alto,utf8_decode('Examen Físico '),1,0,'C',0);
		$fpdf->Ln();
		$fpdf->SetFont('Arial','',$letra-1);

		$peso=$historia_ocupacional->examen_fisico->peso;
    	$talla=$historia_ocupacional->examen_fisico->talla;
    	$imc=$historia_ocupacional->examen_fisico->imc;
    	$ta=$historia_ocupacional->examen_fisico->ta;
    	$fc=$historia_ocupacional->examen_fisico->fc;
    	$fr=$historia_ocupacional->examen_fisico->fr;
    	$lateralidad=$historia_ocupacional->examen_fisico->lateralidad->descripcion;

		$fpdf->Cell(10,$alto-1,utf8_decode('Peso: '),1,0,'C',0);
        $fpdf->Cell(15,$alto-1,number_format($peso,2).' Kg',1,0,'C',0);
		$fpdf->Cell(10,$alto-1,utf8_decode('Talla: '),1,0,'C',0);
		$fpdf->Cell(15,$alto-1,number_format($talla,2).' Mts',1,0,'C',0);
		$fpdf->Cell(10,$alto-1,utf8_decode('IMC: '),1,0,'C',0);
		$fpdf->Cell(15,$alto-1,$imc,1,0,'C',0);
		$fpdf->Cell(10,$alto-1,utf8_decode('TA: '),1,0,'C',0);
		$fpdf->Cell(15,$alto-1,$ta,1,0,'C',0);
		$fpdf->Cell(10,$alto-1,utf8_decode('FC: '),1,0,'C',0);
		$fpdf->Cell(15,$alto-1,$fc,1,0,'C',0);
		$fpdf->Cell(10,$alto-1,utf8_decode('FR: '),1,0,'C',0);
		$fpdf->Cell(15,$alto-1,$fr,1,0,'C',0);
		$fpdf->Cell(20,$alto-1,utf8_decode('Lateralidad: '),1,0,'C',0);
		$fpdf->Cell(20,$alto-1,$lateralidad,1,0,'C',0);

        $fpdf->Ln();
		$array_observaciones=array();
        $alto_columna=35;
 		$ancho_tabla=190;
        $fpdf->SetFont('Arial','B',$letra-1);
        $Tipo_organos = Tipo_organo::whereIn('id',array(1,2,3,4,5,6))->orderby('id')->withCount('organos');
        $cantidades=$Tipo_organos->pluck('organos_count');
		$anchocolumna=$ancho_tabla/$cantidades->sum();
		$arrayaux=array();
		$anchocolumnas= $cantidades->transform(function ($item, $key) use($anchocolumna) {return $item * $anchocolumna;});
		$fpdf->SetWidths($anchocolumnas);
		$fpdf->SetAligns(array('C','C','C','C','C','C'));
		$fpdf->Row($Tipo_organos->pluck('descripcion'));
 		$fpdf->SetFont('Arial','',$letra-2);
		$Tipo_organos=Tipo_organo::whereIn('id',array(1,2,3,4,5,6))->orderby('id')->get();
		if(!is_null($Tipo_organos))
		{
			$margen=10;
			foreach ($Tipo_organos as $Tipo_organo) {
				$Organos=Organo::where(['tipo_organo_id' => $Tipo_organo->id])->orderby('descripcion')->get();
				foreach ($Organos as $Organo) {
					$fpdf->Rect($margen,$fpdf->GetY(),$anchocolumna,$alto_columna,'D');
					$fpdf->RotatedText($margen+4,$fpdf->GetY()+($alto_columna-1),utf8_decode($Organo->descripcion),90);
					$margen=$margen+$anchocolumna;
					$fpdf->SetY($fpdf->GetY()+$alto_columna);
					$fpdf->SetX($margen-$anchocolumna);
					$Exploracion = Exploracion::where(['organo_id' => $Organo->id])->first();
					if(is_null($Exploracion)) {
						$fpdf->Cell($anchocolumna,$alto,'',1,0,'C',0);	
					}else{
						$fpdf->Cell($anchocolumna,$alto,'X',1,0,'C',0);	
						if($Exploracion->resultado!=''){
							$array_observaciones[]=$Organo->descripcion.': '.$Exploracion->resultado;	
						}
					}
					$fpdf->SetY($fpdf->GetY()-$alto_columna);
				}
			}
		}
		$fpdf->SetY($fpdf->GetY()+$alto_columna);
		
		$fpdf->CheckPageBreak($alto+30);

		
 		$alto_columna=30;
 		$ancho_tabla=190;
        $fpdf->SetFont('Arial','B',$letra-1);
        $Tipo_organos = Tipo_organo::whereIn('id',array(7,8,9,10,11))->orderby('id')->withCount('organos');
        $cantidades=$Tipo_organos->pluck('organos_count');
		$anchocolumna=$ancho_tabla/$cantidades->sum();
		$arrayaux=array();
		$anchocolumnas= $cantidades->transform(function ($item, $key) use($anchocolumna) {return $item * $anchocolumna;});
		$fpdf->SetWidths($anchocolumnas);
		$fpdf->SetAligns(array('C','C','C','C','C'));
		$fpdf->Row($Tipo_organos->pluck('descripcion'));
 		$fpdf->SetFont('Arial','',$letra-2);
		$Tipo_organos=Tipo_organo::whereIn('id',array(7,8,9,10,11))->orderby('id')->get();
		if(!is_null($Tipo_organos))
		{
			$margen=10;
			foreach ($Tipo_organos as $Tipo_organo) {
				$Organos=Organo::where(['tipo_organo_id' => $Tipo_organo->id])->orderby('descripcion')->get();
				foreach ($Organos as $Organo) {
					$fpdf->Rect($margen,$fpdf->GetY(),$anchocolumna,$alto_columna,'D');
					$fpdf->RotatedText($margen+3,$fpdf->GetY()+($alto_columna-1),utf8_decode($Organo->descripcion),90);
					$margen=$margen+$anchocolumna;
					$fpdf->SetY($fpdf->GetY()+$alto_columna);
					$fpdf->SetX($margen-$anchocolumna);
					$Exploracion = Exploracion::where(['organo_id' => $Organo->id])->first();
					if(is_null($Exploracion)) {
						$fpdf->Cell($anchocolumna,$alto,'',1,0,'C',0);	
					}else{
						$fpdf->Cell($anchocolumna,$alto,'X',1,0,'C',0);	
						if($Exploracion->resultado!=''){
							$array_observaciones[]=$Organo->descripcion.': '.$Exploracion->resultado;	
						}
					}
					$fpdf->SetY($fpdf->GetY()-$alto_columna);
				}
			}
		}
		$fpdf->SetY($fpdf->GetY()+$alto_columna);
		$fpdf->Ln();
		$Visuales = Visual::where(['historia_ocupacional_id' => $historia_ocupacional->id ])->with('examen_visual.ojo')->with('examen_visual.tipo_examen_visual')->get();
		if($Visuales->count()){
			$fpdf->SetFont('Arial','B',$letra);
			$fpdf->Cell(190,$alto,utf8_decode('Observaciones'),1,0,'C',0);
			$fpdf->Ln();
			$fpdf->SetFont('Arial','',$letra-1);
			$texto=implode('; ', $array_observaciones);
			$fpdf->MultiCell(190,$alto-1,utf8_decode($texto),1,'J',0);

			$fpdf->CheckPageBreak($alto*2+38);
		
			$fpdf->SetFont('Arial','B',$letra);
			$fpdf->Cell(190,$alto,utf8_decode('Prediagnóstico Visual'),1,0,'C',0);
			$fpdf->Ln();
			$fpdf->SetFont('Arial','B',$letra);
			$fpdf->SetWidths(array(50,20,120));
			$fpdf->SetAligns(array('L','C','L'));
			$fpdf->Row(array('Descripcion','Ojo','Observación'));
			$fpdf->SetFont('Arial','',$letra);

			
			foreach ($Visuales as $Visual ) {
				$fpdf->Row(array($Visual->examen_visual->tipo_examen_visual->descripcion,$Visual->examen_visual->ojo->descripcion,$Visual->observacion));
			}
		}
		/*
		$array_observaciones=array();
		$alto_columna=38;
 		$ancho_tabla=190;
        $fpdf->SetFont('Arial','B',$letra-1);
        $Tipo_examen_visuales=Tipo_examen_visual::orderby('id')->pluck('descripcion')->prepend('Ojos');
        $anchocolumna=($ancho_tabla)/$Tipo_examen_visuales->count();
    	$anchocolumnas=array();
		foreach ($Tipo_examen_visuales as $Tipo_examen_visual) {
			$anchocolumnas[]= $anchocolumna;
		}
		
		$fpdf->SetWidths($anchocolumnas);
		$fpdf->SetAligns(array('C','C','C','C','C','C'));
		//dd($Tipo_examen_visuales);
		$fpdf->Row($Tipo_examen_visuales);
 		$fpdf->SetFont('Arial','',$letra-2);
 		$Ojos=Ojo::orderby('descripcion')->get();
 		$fpdf->SetAligns(array('L','L','L','L','L','L'));
 		$arrayfinal=array();
		foreach ($Ojos as $Ojo ) {
			$arrayfinal=array();
			$arrayfinal[]=$Ojo->descripcion;
			$Tipo_examen_visuales=Tipo_examen_visual::orderby('id')->get();
			foreach ($Tipo_examen_visuales as $Tipo_examen_visual ) {
				$Examen_visual = Examen_visual::where([ 'ojo_id' => $Ojo->id, 'tipo_examen_visual_id' => $Tipo_examen_visual->id ])->first();

				if(is_null($Examen_visual)){
					$arrayfinal[]='';
				}else{
					 $Visual = Visual::where(['historia_ocupacional_id' => $historia_ocupacional->id,'examen_visual_id' => $Examen_visual->id ])->first();
					 if(is_null($Visual)){
					 	$arrayfinal[]='';
					 }else{
						$arrayfinal[]=$Visual->descripcion;

					 }
				}
			}
			
			$fpdf->Row($arrayfinal);

		}*/
	
		$fpdf->Ln($alto);
		$fpdf->SetFont('Arial','B',$letra+1);
		$fpdf->Cell(190,6,utf8_decode('PRUEBAS PARACLÍNICAS Y EXÁMENES DE LABORATORIO'),1,0,'C',0);
		$fpdf->Ln();
		$fpdf->SetFont('Arial','B',$letra);
		$fpdf->Cell(60,$alto,utf8_decode('Nombre'),1,0,'L',0);
		$fpdf->Cell(20,$alto,utf8_decode('Fecha'),1,0,'C',0);
		$fpdf->Cell(110,$alto,utf8_decode('Resultado'),1,0,'L',0);
		$fpdf->Ln();

		$fpdf->SetFont('Arial','',$letra-1);
		$Examen_laboratorios=Examen_laboratorio::where(['historia_ocupacional_id'=>$historia_ocupacional_id])->orderby('id')->limit(10)->get();
		if(!is_null($Examen_laboratorios))
		{
			$fpdf->SetWidths(array(60,20,110));
			$fpdf->SetAligns(array('L','C','L'));
			$i=0;
			foreach ($Examen_laboratorios as $Examen_laboratorio) {
				$fpdf->Row(array($Examen_laboratorio->examen,$Examen_laboratorio->fecha->format('d/m/Y'),$Examen_laboratorio->resultado));
				$i=$i+1;
			}
			for($i=$i; $i<10;$i++){
				$fpdf->Row(array('','',''));
			}
		}

		$fpdf->Ln($alto);
		$fpdf->SetFont('Arial','B',$letra+1);
		$fpdf->Cell(190,6,utf8_decode('DIAGNÓSTICO'),1,0,'C',0);
		$fpdf->Ln();
		$fpdf->SetFont('Arial','B',$letra);
		$fpdf->Cell(15,$alto,utf8_decode('Código'),1,0,'C',0);
		$fpdf->Cell(75,$alto,utf8_decode('Diagnostico'),1,0,'L',0);
		$fpdf->Cell(100,$alto,utf8_decode('Concepto'),1,0,'L',0);
		
		$fpdf->Ln();

		$fpdf->SetFont('Arial','',$letra-1);
		$Diagnosticos=Diagnostico::where(['historia_ocupacional_id'=>$historia_ocupacional_id])->with('tipo_diagnostico')->orderby('id')->limit(10)->get();
		$fpdf->SetFont('Arial','',$letra-1);
		$fpdf->SetWidths(array(15,75,100));
		$fpdf->SetAligns(array('C','L','L'));
		if(!is_null($Diagnosticos))
		{
			$i=0;
			foreach ($Diagnosticos as $Diagnostico) {
				$fpdf->Row(array($Diagnostico->tipo_diagnostico->codigo,$Diagnostico->tipo_diagnostico->descripcion,$Diagnostico->concepto));
			}
			for($i=$i; $i<5;$i++){
				$fpdf->Row(array('','',''));
			}
		}

		$fpdf->Ln($alto);
		$fpdf->SetFont('Arial','B',$letra+1);
		$fpdf->Cell(130,6,utf8_decode('CONCEPTO MÉDICO DE APTITUD OCUPACIONAL'),1,0,'L',0);
		$fpdf->SetFont('Arial','B',$letra);
		$fpdf->Cell(60,6,$condicion.' para Laborar',1,0,'C',0);
		$fpdf->Ln();
		$fpdf->SetFont('Arial','',$letra);
		$fpdf->Rect(10,$fpdf->GetY(),190,25,'D');
		$fpdf->MultiCell(190,$alto-1,'Observaciones: '.$observacion,0,'J',0);
		$fpdf->Ln($alto*5);
		
		$fpdf->MultiCell(190,$alto-1,utf8_decode('Certifico que todo lo registrado en la Historia Clínica es verídico, que no he omitido ninguna información sobre mi salud y puede ser confirmada.'),1,'J',0);

		$fpdf->CheckPageBreak($alto*3+20);
		$fpdf->Ln($alto*5);

		if(file_exists( public_path().'/images/firmas/'.$firmatrabajador) &&  $firmatrabajador!='' ){
			$fpdf->Image(asset('images/firmas/'.$firmatrabajador),130,$fpdf->GetY()-13,45,15);
		}
		if(file_exists( public_path().'/images/firmas/'.$firmamedico) &&  $firmamedico!='' ){
			$fpdf->Image(asset('images/firmas/'.$firmamedico),35,$fpdf->GetY()-13,45,15);
		}
		$fpdf->SetFont('Arial','',$letra+1);

		$fpdf->Cell(95,$alto-1,'__________________________________',0,0,'C',0);
		$fpdf->Cell(95,$alto-1,'__________________________________',0,0,'C',0);
		
		$fpdf->Ln();
		$fpdf->Cell(95,$alto-1,$medico,0,0,'C',0);
		$fpdf->Cell(95,$alto-1,$trabajador,0,0,'C',0);

		$fpdf->Ln();
		$fpdf->SetFont('Arial','',$letra+1);
		$fpdf->Cell(95,$alto-1,utf8_decode('Registro Médico ').$registro,0,0,'C',0);
		$fpdf->SetFont('Arial','',$letra+1);
		$fpdf->Cell(95,$alto-1,$cedula,0,0,'C',0);

	
    	$fpdf->Output();
        exit;
		

	}
//--------------CERTIFICADO OCUPACIONAL----------------//
	public function certificado_ocupacional($historia_ocupacional_id)
	{
		$dia='';
    	$mes='';
    	$anio='';
    	$trabajador='';
    	$empresa='';
    	$cedula='';
    	$cargo='';
    	$edad='';
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


		$historia_ocupacional = Historia_ocupacional::where(['id' => $historia_ocupacional_id])->with('arl')->with('afp')->with('empresa')->with('medico_paciente.paciente.user')->with('medico_paciente.medico.user')->with('ocupacional_actual')->with('condicion_diagnostico')->with('tipo_examen')->with('examen_fisico.lateralidad')->first();
		if(!is_null($historia_ocupacional))
		{

			$dia=utf8_decode($historia_ocupacional->created_at->format('d'));
			$mes=utf8_decode($historia_ocupacional->created_at->format('m'));
			$anio=utf8_decode($historia_ocupacional->created_at->format('Y'));
			$trabajador=utf8_decode($historia_ocupacional->medico_paciente->paciente->user->primerapellido.' '.$historia_ocupacional->medico_paciente->paciente->user->primernombre);
			$empresa=utf8_decode($historia_ocupacional->empresa);
			$cedula=utf8_decode($historia_ocupacional->medico_paciente->paciente->user->tipodocumento.' '.$historia_ocupacional->medico_paciente->paciente->user->numerodocumento);
			$cargo=utf8_decode($historia_ocupacional->ocupacional_actual->cargoactual);
			$edad=utf8_decode($historia_ocupacional->medico_paciente->paciente->user->fechanacimiento->diff(Carbon::now())->format('%y años'));
			$firmatrabajador=utf8_decode($historia_ocupacional->medico_paciente->paciente->user->firma);
			$query_eps = Empresa::findOrFail($historia_ocupacional->empresa_id);if(!is_null($query_eps)){ $eps=utf8_decode($query_eps->descripcion);}else{$eps='N/A';}

			$afp=utf8_decode($historia_ocupacional->afp->descripcion);
			$arl=utf8_decode($historia_ocupacional->arl->descripcion);

			$municipio=$historia_ocupacional->medico_paciente->paciente->municipio_id;
			if($municipio==0){
				$municipio='N/A';
			}else{
				$municipio_residencia = municipio::findOrFail($municipio);
				if(!is_null($municipio_residencia))
				{
					$municipio=utf8_decode($municipio_residencia->descripcion);
				}else{
					$municipio='N/A';
				}
			}

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

		$fpdf = new Fpdf();
        $fpdf->AddPage();

        if(file_exists( public_path().'/images/banner/'.$banner) &&  $banner!='' ){
			$fpdf->Image(asset('images/banner/'.$banner),10,8,190,30);
		}

        $fpdf->AliasNbPages();
        $fpdf->SetY(40);
		$fpdf->SetTitle("Certificado Laboral");
		$fpdf->SetFont('Arial','B',10);
		$fpdf->Cell(190,6,'CERTIFICADO DE APTITUD LABORAL',1,0,'C',0);
		$fpdf->Ln();

		$fpdf->SetFont('Arial','',8);
		$fpdf->Cell(40,5,'FECHA: ',1,0,'L',0);
		$fpdf->Cell(30,5,'DIA: '.$dia,1,0,'L',0);
		$fpdf->Cell(30,5,'MES: '.$mes,1,0,'L',0);
		$fpdf->Cell(30,5,utf8_decode('AÑO: ').$anio,1,0,'L',0);
		$fpdf->Cell(5,5,'',0,0,'L',0);
		$fpdf->Cell(55,5,'TIPO DE CERTIFICADO:',1,0,'L',0);

		$fpdf->Ln();
		$fpdf->Cell(40,5,'EMPRESA: ',1,0,'L',0);
		$fpdf->Cell(90,5,$empresa,1,0,'L',0);
		$fpdf->Cell(5,5,'',0,0,'L',0);
		$fpdf->SetFont('Arial','B',9);
		$fpdf->Cell(55,5,$tipoexamen,1,0,'C',0);
		$fpdf->SetFont('Arial','',8);

		$fpdf->Ln();
		$fpdf->Cell(40,5,'TRABAJADOR: ',1,0,'L',0);
		$fpdf->Cell(90,5,$trabajador,1,0,'L',0);

		$fpdf->Ln();
		$fpdf->Cell(40,5,'CEDULA: ',1,0,'L',0);
		$fpdf->Cell(90,5,$cedula,1,0,'L',0);
		$fpdf->Cell(5,5,'',0,0,'L',0);
		$fpdf->Cell(25,5,'PESO: ',1,0,'L',0);
		$fpdf->Cell(30,5,$peso,1,0,'C',0);

		$fpdf->Ln();
		$fpdf->Cell(40,5,'CARGO: ',1,0,'L',0);
		$fpdf->Cell(90,5,$cargo,1,0,'L',0);
		$fpdf->Cell(5,5,'',0,0,'L',0);
		$fpdf->Cell(25,5,'TALLA:',1,0,'L',0);
		$fpdf->Cell(30,5,$talla,1,0,'C',0);
		
		$fpdf->Ln();
		$fpdf->Cell(40,5,'EDAD: ',1,0,'L',0);
		$fpdf->Cell(90,5,$edad,1,0,'L',0);
		$fpdf->Cell(5,5,'',0,0,'L',0);
		$fpdf->Cell(25,5,'IMC:',1,0,'L',0);
		$fpdf->Cell(30,5,$imc,1,0,'C',0);
	
		$fpdf->Ln();
		$fpdf->Cell(40,5,'EPS: ',1,0,'L',0);
		$fpdf->Cell(90,5,$eps,1,0,'L',0);
		$fpdf->Cell(5,5,'',0,0,'L',0);
		$fpdf->Cell(25,5,'TA:',1,0,'L',0);
		$fpdf->Cell(30,5,$ta,1,0,'C',0);

		$fpdf->Ln();
		$fpdf->Cell(40,5,'AFP: ',1,0,'L',0);
		$fpdf->Cell(90,5,$afp,1,0,'L',0);
		$fpdf->Cell(5,5,'',0,0,'L',0);
		$fpdf->Cell(25,5,'FC:',1,0,'L',0);
		$fpdf->Cell(30,5,$fc,1,0,'C',0);
	
		$fpdf->Ln();
		$fpdf->Cell(40,5,'ARL: ',1,0,'L',0);
		$fpdf->Cell(90,5,$arl,1,0,'L',0);
		$fpdf->Cell(5,5,'',0,0,'L',0);
		$fpdf->Cell(25,5,'FR:',1,0,'L',0);
		$fpdf->Cell(30,5,$fr,1,0,'C',0);
	
		$fpdf->Ln();
		$fpdf->Cell(40,5,'MUNICIPIO RESIDENCIA: ',1,0,'L',0);
		$fpdf->Cell(90,5,$municipio,1,0,'L',0);
		$fpdf->Cell(5,5,'',0,0,'L',0);
		$fpdf->Cell(25,5,'LATERALIDAD:',1,0,'L',0);
		$fpdf->Cell(30,5,$lateralidad,1,0,'C',0);
		

		$fpdf->Ln(8);
		$fpdf->SetFont('Arial','B',8);
		$fpdf->Cell(130,5,utf8_decode('CONCEPTO MÉDICO DE APTITUD  OCUPACIONAL'),1,0,'L',0);
		$fpdf->SetFont('Arial','B',9);
		$fpdf->Cell(60,5,$condicion.' para Laborar',1,0,'C',0);
		$fpdf->Ln();
		$fpdf->SetFont('Arial','',8);
		$fpdf->Rect(10,$fpdf->GetY(),190,25,'D');
		$fpdf->MultiCell(190,4,'Observaciones: '.$observacion,0,'J',0);

		$fpdf->SetY(129);
		$fpdf->SetFont('Arial','B',8);
		$fpdf->Cell(190,6,utf8_decode('AYUDAS DIAGNÓSTICAS'),1,0,'C',0);

		$fpdf->SetFont('Arial','',8);
		$fpdf->Ln();
		$fpdf->Cell(140,4,'',0,0,'L',0);
		$fpdf->Cell(25,4,'Normal',1,0,'C',0);
		$fpdf->Cell(25,4,'Alterado',1,0,'C',0);

		$fpdf->SetFont('Arial','',7);
		$tipo_diagnosticos=Tipo_diagnostico::orderby('id')->limit(14)->get();
		foreach ( $tipo_diagnosticos as $tipo_diagnostico ){
			$fpdf->Ln();
			$fpdf->Cell(140,4,$tipo_diagnostico->descripcion,1,0,'L',0);
			$fpdf->Cell(25,4,'',1,0,'C',0);
			$fpdf->Cell(25,4,'',1,0,'C',0);
			
		}

		$fpdf->Ln();
		$fpdf->SetFont('Arial','B',8);
		$fpdf->Cell(190,5,utf8_decode('RECOMENDACIONES MÉDICO LABORAL'),1,0,'C',0);
		$fpdf->Ln();
		$fpdf->Rect(10,$fpdf->GetY(),190,25,'D');
		$fpdf->SetFont('Arial','',8);
		$fpdf->MultiCell(190,4,$recomendaciones,0,'J',0);

		$fpdf->SetY(227);
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
		$fpdf->SetFont('Arial','',8);

		$fpdf->Cell(95,3,'_______________________________',0,0,'C',0);
		$fpdf->Cell(95,3,'_______________________________',0,0,'C',0);
		
		$fpdf->Ln();
		$fpdf->Cell(95,3,$medico,0,0,'C',0);
		$fpdf->Cell(95,3,$trabajador,0,0,'C',0);

		$fpdf->Ln();
		$fpdf->SetFont('Arial','',8);
		$fpdf->Cell(95,3,utf8_decode('Registro Médico ').$registro,0,0,'C',0);
		$fpdf->SetFont('Arial','',8);
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
    	$eps='';
    	$afp='';
    	$arl='';
    	$municipio='';
    	$firmatrabajador='';

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

		$historia_ocupacional = Historia_ocupacional::where(['id' => $historia_ocupacional_id])->with('arl')->with('afp')->with('empresa')->with('medico_paciente.paciente.user')->with('medico_paciente.medico.user')->with('ocupacional_actual')->with('examen_fisico.lateralidad')->with('condicion_altura')->first();
		if(!is_null($historia_ocupacional))
		{

			$dia=utf8_decode($historia_ocupacional->created_at->format('d'));
			$mes=utf8_decode($historia_ocupacional->created_at->format('m'));
			$anio=utf8_decode($historia_ocupacional->created_at->format('Y'));
			$trabajador=utf8_decode($historia_ocupacional->medico_paciente->paciente->user->primerapellido.' '.$historia_ocupacional->medico_paciente->paciente->user->primernombre);
			$empresa=utf8_decode($historia_ocupacional->empresa);
			$cedula=utf8_decode($historia_ocupacional->medico_paciente->paciente->user->tipodocumento.' '.$historia_ocupacional->medico_paciente->paciente->user->numerodocumento);
			$cargo=utf8_decode($historia_ocupacional->ocupacional_actual->cargoactual);
			$edad=utf8_decode($historia_ocupacional->medico_paciente->paciente->user->fechanacimiento->diff(Carbon::now())->format('%y años'));
			$firmatrabajador=utf8_decode($historia_ocupacional->medico_paciente->paciente->user->firma);
			$query_eps = Empresa::findOrFail($historia_ocupacional->empresa_id);if(!is_null($query_eps)){ $eps=utf8_decode($query_eps->descripcion);}else{$eps='N/A';}
			$afp=utf8_decode($historia_ocupacional->afp->descripcion);
			$arl=utf8_decode($historia_ocupacional->arl->descripcion);
			$municipio=$historia_ocupacional->medico_paciente->paciente->municipio_id;
			if($municipio==0){
				$municipio='N/A';
			}else{
				$municipio_residencia = municipio::findOrFail($municipio);
				if(!is_null($municipio_residencia))
				{
					$municipio=utf8_decode($municipio_residencia->descripcion);
				}else{
					$municipio='N/A';
				}
			}
			$peso=$historia_ocupacional->examen_fisico->peso;
	    	$talla=$historia_ocupacional->examen_fisico->talla;
	    	$imc=$historia_ocupacional->examen_fisico->imc;
	    	$ta=$historia_ocupacional->examen_fisico->ta;
	    	$fc=$historia_ocupacional->examen_fisico->fc;
	    	$fr=$historia_ocupacional->examen_fisico->fr;
	    	$lateralidad=$historia_ocupacional->examen_fisico->lateralidad->descripcion;
	       	$condicion=$historia_ocupacional->condicion_altura->condicion;
	    	$observacion=$historia_ocupacional->condicion_altura->observacion;
	    	$medico=utf8_decode($historia_ocupacional->medico_paciente->medico->user->primerapellido.' '.$historia_ocupacional->medico_paciente->medico->user->primernombre);
	    	$registro=utf8_decode($historia_ocupacional->medico_paciente->medico->registro);
	    	$firmamedico=utf8_decode($historia_ocupacional->medico_paciente->medico->user->firma);
	    	$banner=utf8_decode($historia_ocupacional->medico_paciente->medico->banner);



		}
    	
      	$fpdf = new Fpdf();
        $fpdf->AddPage();

        if(file_exists( public_path().'/images/banner/'.$banner) &&  $banner!='' ){
			$fpdf->Image(asset('images/banner/'.$banner),10,8,190,30);
		}

        $fpdf->AliasNbPages();
        $fpdf->SetY(40);
		$fpdf->SetTitle("Cuestionario Altura");
		$fpdf->SetFont('Arial','B',10);
		$fpdf->Cell(190,6,'CUESTIONARIO PARA TRABAJO EN ALTURAS',1,0,'C',0);
		$fpdf->Ln();

		$fpdf->SetFont('Arial','',8);
		$fpdf->Cell(40,5,'FECHA: ',1,0,'L',0);
		$fpdf->Cell(30,5,'DIA: '.$dia,1,0,'L',0);
		$fpdf->Cell(30,5,'MES: '.$mes,1,0,'L',0);
		$fpdf->Cell(30,5,utf8_decode('AÑO: ').$anio,1,0,'L',0);
		$fpdf->Cell(5,5,'',0,0,'L',0);
		$fpdf->Cell(25,5,'PESO: ',1,0,'L',0);
		$fpdf->Cell(30,5,$peso,1,0,'C',0);

		$fpdf->Ln();
		$fpdf->Cell(40,5,'EMPRESA: ',1,0,'L',0);
		$fpdf->Cell(90,5,$empresa,1,0,'L',0);
		$fpdf->Cell(5,5,'',0,0,'L',0);
		$fpdf->Cell(25,5,'TALLA:',1,0,'L',0);
		$fpdf->Cell(30,5,$talla,1,0,'C',0);

		$fpdf->Ln();
		$fpdf->Cell(40,5,'TRABAJADOR: ',1,0,'L',0);
		$fpdf->Cell(90,5,$trabajador,1,0,'L',0);
		$fpdf->Cell(5,5,'',0,0,'L',0);
		$fpdf->Cell(25,5,'IMC:',1,0,'L',0);
		$fpdf->Cell(30,5,$imc,1,0,'C',0);

		$fpdf->Ln();
		$fpdf->Cell(40,5,'CEDULA: ',1,0,'L',0);
		$fpdf->Cell(90,5,$cedula,1,0,'L',0);
		$fpdf->Cell(5,5,'',0,0,'L',0);
		$fpdf->Cell(25,5,'TA:',1,0,'L',0);
		$fpdf->Cell(30,5,$ta,1,0,'C',0);
		
		$fpdf->Ln();
		$fpdf->Cell(40,5,'CARGO: ',1,0,'L',0);
		$fpdf->Cell(90,5,$cargo,1,0,'L',0);
		$fpdf->Cell(5,5,'',0,0,'L',0);
		$fpdf->Cell(25,5,'FC:',1,0,'L',0);
		$fpdf->Cell(30,5,$fc,1,0,'C',0);

		$fpdf->Ln();
		$fpdf->Cell(40,5,'EDAD: ',1,0,'L',0);
		$fpdf->Cell(90,5,$edad,1,0,'L',0);
		$fpdf->Cell(5,5,'',0,0,'L',0);
		$fpdf->Cell(25,5,'FR:',1,0,'L',0);
		$fpdf->Cell(30,5,$fr,1,0,'C',0);

		$fpdf->Ln();
		$fpdf->Cell(40,5,'EPS: ',1,0,'L',0);
		$fpdf->Cell(90,5,$eps,1,0,'L',0);
		$fpdf->Cell(5,5,'',0,0,'L',0);
		$fpdf->Cell(25,5,'LATERALIDAD:',1,0,'L',0);
		$fpdf->Cell(30,5,$lateralidad,1,0,'C',0);

		$fpdf->Ln();
		$fpdf->Cell(40,5,'AFP: ',1,0,'L',0);
		$fpdf->Cell(90,5,$afp,1,0,'L',0);
	

		$fpdf->Ln();
		$fpdf->Cell(40,5,'ARL: ',1,0,'L',0);
		$fpdf->Cell(90,5,$arl,1,0,'L',0);
		

		$fpdf->Ln();
		$fpdf->Cell(40,5,'MUNICIPIO RESIDENCIA: ',1,0,'L',0);
		$fpdf->Cell(90,5,$municipio,1,0,'L',0);
		
	

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
		$fpdf->SetFont('Arial','B',8);
		$fpdf->Cell(140,5,utf8_decode('CONDICIÓN PARA TRABAJAR EN ALTURAS'),1,0,'L',0);
		$fpdf->Cell(50,5,$condicion,1,0,'C',0);
		$fpdf->Ln();
		$fpdf->SetFont('Arial','',8);
		$fpdf->Cell(190,5,utf8_decode('OBSERVACIONES'),1,0,'C',0);
		$fpdf->Ln();
		$fpdf->Rect(10,$fpdf->GetY(),190,35,'D');
		$fpdf->MultiCell(190,4,$observacion,0,'J',0);

		$fpdf->SetY(265);
		if(file_exists( public_path().'/images/firmas/'.$firmatrabajador) &&  $firmatrabajador!='' ){
			$fpdf->Image(asset('images/firmas/'.$firmatrabajador),130,252,45,15);
		}
		if(file_exists( public_path().'/images/firmas/'.$firmamedico) &&  $firmamedico!='' ){
			$fpdf->Image(asset('images/firmas/'.$firmamedico),35,252,45,15);
		}

		$fpdf->Cell(95,3,'_______________________________',0,0,'C',0);
		$fpdf->Cell(95,3,'_______________________________',0,0,'C',0);
		
		$fpdf->Ln();
		$fpdf->Cell(95,3,$medico,0,0,'C',0);
		$fpdf->Cell(95,3,$trabajador,0,0,'C',0);

		$fpdf->Ln();
		$fpdf->SetFont('Arial','',7);
		$fpdf->Cell(95,3,utf8_decode('Registro Médico ').$registro,0,0,'C',0);
		$fpdf->SetFont('Arial','',8);
		$fpdf->Cell(95,3,$cedula,0,0,'C',0);
    	$fpdf->Output();
        exit;

    }
}
