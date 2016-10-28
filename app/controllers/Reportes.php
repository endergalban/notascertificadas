<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Reportes extends CI_Controller {

	public function __construct() {
		parent::__construct();
			$this->load->model('usuarios');
			$this->load->library('pdf');
	}
//--------------CONFIGURACION----------------//
	var $widths;
	var $aligns;

	function SetWidths($w)
	{
		//Set the array of column widths
		$this->pdf->widths=$w;
	}

	function SetAligns($a)
	{
		//Set the array of column alignments
		$this->pdf->aligns=$a;
	}

	function Row($data)
	{
		//Calculate the height of the row
		$nb=0;
		for($i=0;$i<count($data);$i++)
			$nb=max($nb,$this->NbLines($this->pdf->widths[$i],$data[$i]));
		$h=4.5*$nb;
		//Issue a page break first if needed
		$this->CheckPageBreak($h);
		//Draw the cells of the row
		for($i=0;$i<count($data);$i++)
		{
			$w=$this->pdf->widths[$i];
			$a=isset($this->pdf->aligns[$i]) ? $this->pdf->aligns[$i] : 'L';
			//Save the current position
			$x=$this->pdf->GetX();
			$y=$this->pdf->GetY();
			//Draw the border

			$this->pdf->Rect($x,$y,$w,$h,'DF');
			//Print the text
			$this->pdf->MultiCell($w,4.5,$data[$i],0,$a);
			//Put the position to the right of the cell
			$this->pdf->SetXY($x+$w,$y);
		}
		//Go to the next line
		$this->pdf->Ln($h);
	}

	function CheckPageBreak($h)
	{
		//If the height h would cause an overflow, add a new page immediately
		if($this->pdf->GetY()+$h>$this->pdf->PageBreakTrigger)
			$this->pdf->AddPage($this->pdf->CurOrientation);
	}

	function NbLines($w,$txt)
	{
		//Computes the number of lines a MultiCell of width w will take
		$cw=&$this->pdf->CurrentFont['cw'];
		if($w==0)
			$w=$this->w-$this->pdf->rMargin-$this->pdf->x;
		$wmax=($w-2*$this->pdf->cMargin)*1000/$this->pdf->FontSize;
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

	function nrogrado($nro){

		if($nro==1){
			return '1er';
		}elseif($nro==2){
			return '2do';
		}elseif($nro==3){
			return '3er';
		}elseif($nro==4){
			return '4to';
		}elseif($nro==5){
			return '5to';
		}elseif($nro==6){
			return '6to';
		}else{
			return 'N/A';
		}
	}

	function sabernota($nro){

		if($nro==1){
			return 'CERO UNO';
		}elseif($nro==2){
			return 'CERO DOS';
		}elseif($nro==3){
			return 'CERO TRES';
		}elseif($nro==4){
			return 'CERO CUATRO';
		}elseif($nro==5){
			return 'CERO CINCO';
		}elseif($nro==6){
			return 'CERO SEIS';
		}elseif($nro==7){
			return 'CERO SIETE';
		}elseif($nro==8){
			return 'CERO OCHO';
		}elseif($nro==9){
			return 'CERO NUEVE';
		}elseif($nro==10){
			return 'DIEZ';
		}elseif($nro==11){
			return 'ONCE';
		}elseif($nro==12){
			return 'DOCE';
		}elseif($nro==13){
			return 'TRECE';
		}elseif($nro==14){
			return 'CATORCE';
		}elseif($nro==15){
			return 'QUINCE';
		}elseif($nro==16){
			return 'DIECISEIS';
		}elseif($nro==17){
			return 'DIECISIETE';
		}elseif($nro==18){
			return 'DIECIOCHO';
		}elseif($nro==19){
			return 'DIECINUEVE';
		}elseif($nro==20){
			return 'VEINTE';
		}else{
			return 'N/A';
		}
	}

	function sabermes($nro){

		if($nro=='01'){
			return 'ENERO';
		}elseif($nro=='02'){
			return 'FEBRERO';
		}elseif($nro=='03'){
			return 'MARZO';
		}elseif($nro=='04'){
			return 'ABRIL';
		}elseif($nro=='05'){
			return 'MAYO';
		}elseif($nro=='06'){
			return 'JUNIO';
		}elseif($nro=='07'){
			return 'JULIO';
		}elseif($nro=='08'){
			return 'AGOSTO';
		}elseif($nro=='09'){
			return 'SEPTIEMBRE';
		}elseif($nro=='10'){
			return 'OCTUBRE';
		}elseif($nro=='11'){
			return 'NOVIEMBRE';
		}elseif($nro=='12'){
			return 'DICIEMBRE';
		}else{
			return 'N/A';
		}
	}

	function saber_escuela($ARRAY,$ID_ESCUELA_EXTERNA){
		$nro=0;

		for($i=0;$i<count($ARRAY);$i++) //CODIGO MATERIAS
		{

			if($ARRAY[$i]==$ID_ESCUELA_EXTERNA)
			{
				$nro=$i+1;
				return $nro;
			}
		}
		return $nro;
	}

//--------------FIN CONFIGURACION----------------//
	public function index()
	{

	}
	public function rep_estudiantes($id=null)
	{
		if($this->usuarios->autorizacion('rep_estudiantes')){
			$this->pdf->SetFillColor(255,255,255);
			$this->load->model('estudiantes');
			$this->pdf->AddPage();
			$this->pdf->AliasNbPages();
			$this->pdf->SetTitle("Lista de Estudiantes");
			$this->pdf->SetFont('Arial','UB',10);
			$this->pdf->Cell(190,5,'Lista de Estudiantes',0,0,'C',0);
			$this->pdf->Ln(10);
			$this->pdf->SetFont('Arial','I',9);
			$this->SetWidths(array(10,30,30,25,25,35,35));
			$this->SetAligns(array('C','L','L','C','C','C','C'));
			$this->Row(array('Nro','Apellidos','Nombres',utf8_decode('Identificación'),'Fecha Nac.','Lugar Nac.',utf8_decode('Entidad o País')));
			$x = 1;
			if( $this->estudiantes->registros($this->session->userdata('idusuario')))
			{
				$estudiantes=$this->estudiantes->registros($this->session->userdata('idusuario'));
				foreach ($estudiantes->result_array() as $estudiante) {
					$this->Row(array($x++,utf8_decode($estudiante['apellido']),utf8_decode($estudiante['nombre']),utf8_decode($estudiante['cedula']),date('d-m-Y',strtotime($estudiante['fechanac'])),utf8_decode($estudiante['lugarnacimiento']),utf8_decode($estudiante['entidad'])));
				}
			}

			$this->pdf->Output("Lista de Estudiantes.pdf", 'I');
		}else{
			show_error('No tienes permiso para realizar está función. Por Favor contacte con el administrador', 403, $heading = 'Acceso Denegado');
		}
	}

	public function rep_escuelasforaneas($id=null)
	{
		if($this->usuarios->autorizacion('rep_escuelasforaneas')){
			$this->pdf->SetFillColor(255,255,255);
			$this->load->model('escuelasforaneas');
			$this->pdf->AddPage();
			$this->pdf->AliasNbPages();
			$this->pdf->SetTitle("Lista de Escuelas Foraneas");
			$this->pdf->SetFont('Arial','UB',10);
			$this->pdf->Cell(190,5,'Listado de Escuelas Foraneas',0,0,'C',0);
			$this->pdf->Ln(10);

			$this->pdf->SetFont('Arial','I',9);
			$this->SetWidths(array(10,60,40,50,25));
			$this->SetAligns(array('C','L','C','C','C'));
			$this->Row(array('Nro','Nombre','Localidad','Entidad',utf8_decode('Código')));
			$x = 1;
			if($this->escuelasforaneas->registros($this->session->userdata('idusuario')))
			{
				$rs_escuelas = $this->escuelasforaneas->registros($this->session->userdata('idusuario'));
				foreach ($rs_escuelas->result_array() as $fila)
				{
					$this->Row(array($x++,utf8_decode($fila['nombre']),utf8_decode($fila['localidad']),utf8_decode($fila['entidad']),str_pad($fila["idescuelaforanea"],5,'0',STR_PAD_LEFT)));
				}
			}
			$this->pdf->Output("Lista de Escuelas Foraneas.pdf", 'I');
		}else{
			show_error('No tienes permiso para realizar está función. Por Favor contacte con el administrador', 403, $heading = 'Acceso Denegado');
		}
	}

	public function rep_certificaciones($idestudiante=0,$grado=null)
	{
		if($this->usuarios->autorizacion('rep_certificaciones')){
			$this->load->model('calificaciones');
			$this->load->model('escuelasforaneas');

			$plan='';
			$codigo='';
			$mencion='';
			$idescuela=0;
			$observaciones=array();
			$nombre_escuela='';
			$codigo_escuela='';
			$distrito_escuela='';
			$direccion_escuela='';
			$telefono_escuela='';
			$municipio_escuela='';
			$entidad_escuela='';
			$director_escuela='';
			$zona_escuela='';
			$ceduladirector_escuela='';
			$apellido='';
			$nombre='';
			$cedula='';
			$fechanac='';
			$lugarnacimiento='';
			$entidad='';


			$materiaset=array();
			$escuelasforaneas=array();
			$escuelasforaneasdata=array();
			$materias=array();

			if($grado>3)
			{
				$inigrado=3;
			}else{
				$inigrado=0;
			}

			if($idestudiante && $grado)
			{

				$result=$this->calificaciones->plan($idestudiante,$grado);
				if($result){
					$plan=utf8_decode($result['plan']);
					$codigo=utf8_decode($result['codigo']);
					$mencion=utf8_decode($result['mencion']);
					$idescuela=utf8_decode($result['idescuela']);
					for($i=$inigrado;$i<$grado;$i++)
					{
						$result=$this->calificaciones->plan($idestudiante,($i+1));
						if($result){
							if($result['observacion']!=''){
								$observaciones[]=$result['observacion'];
							}
						}
						$rs_materiaset=$this->calificaciones->listaet($idestudiante,($i+1));
						if($rs_materiaset){
							foreach ($rs_materiaset->result_array() as $fila)
							{
								$materiaset[]=$this->nrogrado($i+1).','.utf8_decode($fila['nombre']).','.utf8_decode(str_pad($fila["horas"],2,'0',STR_PAD_LEFT));
							}
						}

						$rs_materias=$this->calificaciones->listamaterias($idestudiante,($i+1));
						if($rs_materias){
							foreach ($rs_materias->result_array() as $fila)
							{
								if(!in_array($fila['idescuelaforanea'],$escuelasforaneas))
								{
									$escuelasforaneas[]=$fila['idescuelaforanea'];
								}
							}

						}


					}
					for($i=0;$i<count($escuelasforaneas);$i++){
						$registro=$this->escuelasforaneas->escuela($this->session->userdata('idusuario'),$escuelasforaneas[$i]);
						if($registro)
						{
							$escuelasforaneasdata[]=$registro['nombre'].','.$registro['localidad'].','.$registro['entidad'];
						}
					}

					$this->load->model('escuelas');
					$result=$this->escuelas->escuela($this->session->userdata('idusuario'),$idescuela);
					if($result){
						$nombre_escuela=utf8_decode($result['nombre']);
						$codigo_escuela=utf8_decode($result['codigo']);
						$distrito_escuela=utf8_decode($result['distrito']);
						$direccion_escuela=utf8_decode($result['direccion']);
						$telefono_escuela=utf8_decode($result['telefono']);
						$municipio_escuela=utf8_decode($result['municipio']);
						$entidad_escuela=utf8_decode($result['entidad']);
						$director_escuela=utf8_decode($result['director']);
						$zona_escuela=utf8_decode($result['zona']);
						$ceduladirector_escuela=utf8_decode($result['ceduladirector']);
					}


					$this->load->model('estudiantes');
					$result=$this->estudiantes->estudiante($this->session->userdata('idusuario'),$idestudiante);
					if($result){
						$apellido=utf8_decode($result['apellido']);
						$nombre=utf8_decode($result['nombre']);
						$cedula=utf8_decode($result['cedula']);
						$fechanac=utf8_decode(date('d-m-Y',strtotime($result['fechanac'])));
						$lugarnacimiento=utf8_decode($result['lugarnacimiento']);
						$entidad=utf8_decode($result['entidad']);
					}
				}
			}
			for($i=count($materiaset);$i<10;$i++)
			{
				$materiaset[]='--,--,--';
			}

			for($i=count($escuelasforaneasdata);$i<5;$i++)
			{
				$escuelasforaneasdata[]='--,--,--';
			}


		//	$this->calificaciones->plan($idestudiante,$grado);
			$this->pdf->SetFillColor(255,255,255);
			$this->load->model('estudiantes');
			$this->pdf->AddPage('P','Legal');
			$this->pdf->AliasNbPages();
			$this->pdf->SetTitle("Notas Certificada");
			$this->pdf->SetAutoPageBreak(true,1);

			$this->pdf->Image(site_url(array('images','ministerio.jpg')),7,7,95);
			$h=7;//MARGEN IZQUIERDO
			$a=4;//ALTO DE CELDAS
			$l=8;//TAMAÑO DE LETRA
			$this->pdf->SetY($h);
			$this->pdf->SetFont('Arial','',$l);
			$this->pdf->SetFillColor(255,255,255);
			$this->pdf->SetFont('Arial','UB',11);
			$this->pdf->SetX($h);
			$this->pdf->Cell(180,$a,"CERTIFICACION DE CALIFICACIONES",0,0,'R');
			$this->pdf->Ln();
			$this->pdf->SetX($h);
			$this->pdf->SetFont('Arial','UB',$l);
			$this->pdf->Cell(90,$a,"",0,0,'L',0);
			$this->pdf->SetFont('Arial','B',9);
			$this->pdf->Cell(60,$a,utf8_decode("Código del Formato: RR-DEA-03-03"),0,0,'R',0);
			$this->pdf->Ln();


			$this->pdf->SetX($h);
			$this->pdf->SetFont('Arial','',$l);
			$this->pdf->Cell(95,$a,"",0,0,'L',0);
			$this->pdf->Cell(28,$a,"I. Plan de Estudio:",0,0,'L',0);
			$this->pdf->SetFont('Arial','',$l);
			$this->pdf->Cell(77,$a,$plan,'B',0,'C',0);
			$this->pdf->Ln();

			$this->pdf->SetX($h);
			$this->pdf->SetFont('Arial','',$l);
			$this->pdf->Cell(95,$a,"",0,0,'L',0);
			$this->pdf->Cell(40,$a,utf8_decode("Código del Plan de Estudio:"),0,0,'L',0);
			$this->pdf->SetFont('Arial','',$l);
			$this->pdf->Cell(65,$a,$codigo,'B',0,'C',0);
			$this->pdf->Ln();
			$this->pdf->SetX($h);
			$this->pdf->SetFont('Arial','',$l);
			$this->pdf->Cell(95,$a,utf8_decode("II. Datos del Plantel o Zona Educativa que emite la Certificación:"),0,0,'L',0);
			$this->pdf->Cell(17,$a,utf8_decode("Mención:"),0,0,'L',0);
			$this->pdf->SetFont('Arial','',$l);
			$this->pdf->Cell(88,$a,$mencion,'B',0,'C',0);
			$this->pdf->SetFont('Arial','',$l);
			$this->pdf->Ln();
			$this->pdf->SetX($h);
			$this->pdf->SetFont('Arial','',$l);
			$this->pdf->Cell(18,$a,utf8_decode("Cód. Plantel:"),0,0,'L',0);
			$this->pdf->SetFont('Arial','',$l);
			$this->pdf->Cell(35,$a,$codigo_escuela,'B',0,'C',0);
			$this->pdf->SetFont('Arial','',$l);
			$this->pdf->Cell(15,$a,"Nombre:",0,0,'L',0);
			$this->pdf->SetFont('Arial','',$l);
			$this->pdf->Cell(95,$a,$nombre_escuela,'B',0,'L',0);
			$this->pdf->SetFont('Arial','',$l);
			$this->pdf->Cell(15,$a,"Dtto.Esc.:",0,0,'L',0);
			$this->pdf->SetFont('Arial','',$l);
			$this->pdf->Cell(20,$a,$distrito_escuela,'B',0,'C',0);
			$this->pdf->Ln();
			$this->pdf->SetX($h);
			$this->pdf->SetFont('Arial','',$l);
			$this->pdf->Cell(20,$a,utf8_decode("Dirección:"),0,0,'L',0);
			$this->pdf->SetFont('Arial','',$l);
			$this->pdf->Cell(140,$a,$direccion_escuela,'B',0,'L',0);
			$this->pdf->SetFont('Arial','',$l);
			$this->pdf->Cell(20,$a,utf8_decode("Teléfono:"),0,0,'L',0);
			$this->pdf->SetFont('Arial','',$l);
			$this->pdf->Cell(20,$a,$telefono_escuela,'B',0,'C',0);
			$this->pdf->Ln();
			$this->pdf->SetX($h);
			$this->pdf->SetFont('Arial','',$l);
			$this->pdf->Cell(15,$a,utf8_decode("Municipio:"),0,0,'L',0);
			$this->pdf->SetFont('Arial','',$l);
			$this->pdf->Cell(55,$a,$municipio_escuela,'B',0,'C',0);
			$this->pdf->SetFont('Arial','',$l);
			$this->pdf->Cell(20,$a,utf8_decode("Ent.Federal:"),0,0,'L',0);
			$this->pdf->SetFont('Arial','',$l);
			$this->pdf->Cell(45,$a,$entidad_escuela,'B',0,'C',0);
			$this->pdf->SetFont('Arial','',$l);
			$this->pdf->Cell(28,$a,utf8_decode("Zona Educativa:"),0,0,'L',0);
			$this->pdf->SetFont('Arial','',$l);
			$this->pdf->Cell(37,$a,$zona_escuela,'B',0,'C',0);
			$this->pdf->Ln();

			$this->pdf->SetX($h);
			$this->pdf->SetFont('Arial','',$l);
			$this->pdf->Cell(115,$a,utf8_decode("III. Datos de Identificación del Alumno:"),0,0,'L',0);
			$this->pdf->Ln();


			$this->pdf->SetX($h);
			$this->pdf->SetFont('Arial','',$l);
			$this->pdf->Cell(30,$a,utf8_decode("Cédula de Identidad:"),0,0,'L',0);
			$this->pdf->SetFont('Arial','',$l);
			$this->pdf->Cell(100,$a,$cedula,'B',0,'C',0);
			$this->pdf->SetFont('Arial','',$l);
			$this->pdf->Cell(35,$a,utf8_decode("Fecha de Nacimiento:"),0,0,'L',0);
			$this->pdf->SetFont('Arial','',$l);
			$this->pdf->Cell(35,$a,$fechanac,'B',0,'C',0);
			$this->pdf->Ln();


			$this->pdf->SetX($h);
			$this->pdf->SetFont('Arial','',$l);
			$this->pdf->Cell(15,$a,utf8_decode("Apellidos:"),0,0,'L',0);
			$this->pdf->SetFont('Arial','',$l);
			$this->pdf->Cell(85,$a,$apellido,'B',0,'C',0);
			$this->pdf->SetFont('Arial','',$l);
			$this->pdf->Cell(15,$a,utf8_decode("Nombres:"),0,0,'L',0);
			$this->pdf->SetFont('Arial','',$l);
			$this->pdf->Cell(85,$a,$nombre,'B',0,'C',0);
			$this->pdf->Ln();

			$this->pdf->SetX($h);
			$this->pdf->SetFont('Arial','',$l);
			$this->pdf->Cell(35,$a,utf8_decode("Lugar de Nacimiento:"),0,0,'L',0);
			$this->pdf->SetFont('Arial','',$l);
			$this->pdf->Cell(70,$a,$lugarnacimiento,'B',0,'C',0);
			$this->pdf->SetFont('Arial','',$l);
			$this->pdf->Cell(30,$a,utf8_decode("Ent. Federal o Pais :"),0,0,'L',0);
			$this->pdf->SetFont('Arial','',$l);
			$this->pdf->Cell(65,$a,$entidad,'B',0,'C',0);
			$this->pdf->Ln();

			$this->pdf->SetX($h);
			$this->pdf->SetFont('Arial','',$l);
			$this->pdf->Cell(115,$a,utf8_decode("IV. Planteles donde cursó estudios:"),0,0,'L',0);
			$this->pdf->Ln();

			//PLANTELES
			$h=8;
			$a=3.7;
			$l=7;
			$this->pdf->SetX($h);
			$this->pdf->SetFont('Arial','',$l);
			$this->pdf->Cell(7,$a,utf8_decode("No:"),1,0,'C',1);
			$this->pdf->Cell(48,$a,utf8_decode("Nombre del Plantel:"),1,0,'L',1);
			$this->pdf->Cell(35,$a,utf8_decode("Localidad"),1,0,'L',1);
			$this->pdf->Cell(10,$a,utf8_decode("E.F."),1,0,'C',1);
			$this->pdf->Cell(7,$a,utf8_decode("No:"),1,0,'C',1);
			$this->pdf->Cell(48,$a,utf8_decode("Nombre del Plantel:"),1,0,'L',1);
			$this->pdf->Cell(35,$a,utf8_decode("Localidad"),1,0,'L',1);
			$this->pdf->Cell(10,$a,utf8_decode("E.F."),1,0,'C',1);
			$this->pdf->Ln();


			$escuelasforanea=explode(',',$escuelasforaneasdata[0]);
			$this->pdf->SetX($h);
			$this->pdf->SetFont('Arial','',$l);
			$this->pdf->Cell(7,$a,utf8_decode("1"),1,0,'C',1);
			$this->pdf->Cell(48,$a,$escuelasforanea[0],1,0,'C',1);
			$this->pdf->Cell(35,$a,$escuelasforanea[1],1,0,'C',1);
			$this->pdf->Cell(10,$a,$escuelasforanea[2],1,0,'C',1);

			$escuelasforanea=explode(',',$escuelasforaneasdata[3]);
			$this->pdf->Cell(7,$a,utf8_decode("4"),1,0,'C',1);
			$this->pdf->Cell(48,$a,$escuelasforanea[0],1,0,'C',1);
			$this->pdf->Cell(35,$a,$escuelasforanea[1],1,0,'C',1);
			$this->pdf->Cell(10,$a,$escuelasforanea[2],1,0,'C',1);
			$this->pdf->Ln();

			$this->pdf->SetX($h);
			$this->pdf->SetFont('Arial','',$l);
			$escuelasforanea=explode(',',$escuelasforaneasdata[1]);
			$this->pdf->Cell(7,$a,utf8_decode("2"),1,0,'C',1);
			$this->pdf->Cell(48,$a,$escuelasforanea[0],1,0,'C',1);
			$this->pdf->Cell(35,$a,$escuelasforanea[1],1,0,'C',1);
			$this->pdf->Cell(10,$a,$escuelasforanea[2],1,0,'C',1);

			$escuelasforanea=explode(',',$escuelasforaneasdata[4]);
			$this->pdf->Cell(7,$a,utf8_decode("5"),1,0,'C',1);
			$this->pdf->Cell(48,$a,$escuelasforanea[0],1,0,'C',1);
			$this->pdf->Cell(35,$a,$escuelasforanea[1],1,0,'C',1);
			$this->pdf->Cell(10,$a,$escuelasforanea[2],1,0,'C',1);
			$this->pdf->Ln();
			$this->pdf->SetX($h);
			$this->pdf->SetFont('Arial','',$l);
			$escuelasforanea=explode(',',$escuelasforaneasdata[2]);
			$this->pdf->Cell(7,$a,utf8_decode("3"),1,0,'C',1);
			$this->pdf->Cell(48,$a,$escuelasforanea[0],1,0,'C',1);
			$this->pdf->Cell(35,$a,$escuelasforanea[1],1,0,'C',1);
			$this->pdf->Cell(10,$a,$escuelasforanea[2],1,0,'C',1);
			$this->pdf->Ln();
			$this->pdf->SetX(7);
			$this->pdf->SetFont('Arial','',$l);
			$this->pdf->Cell(115,$a,utf8_decode("V. Pensum de Estudios:"),0,0,'L',0);
			$this->pdf->Ln();


			for($i=$inigrado;$i<($inigrado+3);$i++) //CODIGO MATERIAS
			{
				$this->pdf->SetX($h);
				$this->pdf->SetFont('Arial','',$l);
				$this->pdf->Cell(20,$a,utf8_decode("Año o Grado"),"TBL",0,'L',1);
				$this->pdf->Cell(37,$a,$this->nrogrado($i+1).' '.utf8_decode(" Año "),"TBR",0,'L',1);
				$this->pdf->Cell(42,$a,utf8_decode("Calificaciones"),1,0,'C',1);
				$this->pdf->Cell(7,($a*2),utf8_decode("T-E"),1,0,'C',0);
				$this->pdf->Cell(14,$a,utf8_decode("Fecha"),1,0,'C',1);
				$this->pdf->Cell(12,$a,utf8_decode("Plantel"),1,0,'C',1);
				$this->pdf->Ln();
				$this->pdf->SetX($h);
				$this->pdf->Cell(57,$a,utf8_decode("Asignaturas"),1,0,'L',1);
				$this->pdf->Cell(7,$a,utf8_decode("En No"),1,0,'C',1);
				$this->pdf->Cell(35,$a,utf8_decode("En Letras"),1,0,'C',1);
				$this->pdf->Cell(7,($a),utf8_decode(""),0,0,'C',0);
				$this->pdf->Cell(7,$a,utf8_decode("Mes"),1,0,'C',1);
				$this->pdf->Cell(7,$a,utf8_decode("Año"),1,0,'C',1);
				$this->pdf->Cell(12,$a,utf8_decode("No"),1,0,'C',1);
				$this->pdf->Ln();
				$this->pdf->SetFont('Arial','',$l);

				$x=0;
				$rs_materias=$this->calificaciones->listamaterias($idestudiante,($i+1));
				if(($rs_materias) && ($i<$grado)){
					foreach ($rs_materias->result_array() as $fila)
					{
						//$materias[]=$fila['materia'].','.$fila['nota'].','.$fila['tipo'].','.$fila['mes'].','.$fila['anio'].','.$fila['idescuelaforanea'];
						if($fila['tipo']=='C')
						{
							$this->pdf->SetX($h);
							$this->pdf->Cell(57,$a,utf8_decode($fila['materia']),1,0,'L',1);
							$this->pdf->Cell(7,$a,'C',1,0,'C',1);
							$this->pdf->Cell(35,$a,'CURSADA',1,0,'L',1);
							$this->pdf->Cell(7,$a,utf8_decode($fila['tipo']),1,0,'C',1);
							$this->pdf->Cell(7,$a,utf8_decode($fila['mes']),1,0,'C',1);
							$this->pdf->Cell(7,$a,utf8_decode($fila['anio']),1,0,'C',1);
							$this->pdf->Cell(12,$a,utf8_decode($this->saber_escuela($escuelasforaneas,$fila['idescuelaforanea'])),1,0,'C',1);

						}elseif($fila['tipo']=='CAB'){
							$this->pdf->SetX($h);
							$this->pdf->Cell(57,$a,utf8_decode($fila['materia']),1,0,'L',1);
							$this->pdf->Cell(75,$a,utf8_decode("APROBADO CONVENIO ANDRÉS BELLO"),1,0,'C',1);

						}elseif($fila['tipo']=='EX'){
							$this->pdf->SetX($h);
							$this->pdf->Cell(57,$a,utf8_decode($fila['materia']),1,0,'L',1);
							$this->pdf->Cell(7,$a,'EX',1,0,'C',1);
							$this->pdf->Cell(35,$a,'EXONERADA',1,0,'L',1);
							$this->pdf->Cell(7,$a,utf8_decode('***'),1,0,'C',1);
							$this->pdf->Cell(7,$a,utf8_decode('***'),1,0,'C',1);
							$this->pdf->Cell(7,$a,utf8_decode('***'),1,0,'C',1);
							$this->pdf->Cell(12,$a,utf8_decode('***'),1,0,'C',1);

						}elseif($fila['tipo']=='EQ'){
							$this->pdf->SetX($h);
							$this->pdf->Cell(57,$a,utf8_decode($fila['materia']),1,0,'L',1);
							$this->pdf->Cell(7,$a,utf8_decode($fila['nota']),1,0,'C',1);
							$this->pdf->Cell(35,$a,utf8_decode($this->sabernota($fila['nota'])),1,0,'L',1);
							$this->pdf->Cell(7,$a,utf8_decode('E'),1,0,'C',1);
							$this->pdf->Cell(7,$a,utf8_decode($fila['mes']),1,0,'C',1);
							$this->pdf->Cell(7,$a,utf8_decode($fila['anio']),1,0,'C',1);
							$this->pdf->Cell(12,$a,utf8_decode($this->saber_escuela($escuelasforaneas,$fila['idescuelaforanea'])),1,0,'C',1);
						}elseif($fila['tipo']=='P'){
							$this->pdf->SetX($h);
							$this->pdf->Cell(57,$a,utf8_decode($fila['materia']),1,0,'L',1);
							$this->pdf->Cell(7,$a,'P',1,0,'C',1);
							$this->pdf->Cell(35,$a,'PENDIENTE',1,0,'L',1);
							$this->pdf->Cell(7,$a,utf8_decode('P'),1,0,'C',1);
							$this->pdf->Cell(7,$a,utf8_decode($fila['mes']),1,0,'C',1);
							$this->pdf->Cell(7,$a,utf8_decode($fila['anio']),1,0,'C',1);
							$this->pdf->Cell(12,$a,utf8_decode($this->saber_escuela($escuelasforaneas,$fila['idescuelaforanea'])),1,0,'C',1);
						}elseif($fila['tipo']=='PR'){
							$this->pdf->SetX($h);
							$this->pdf->Cell(57,$a,utf8_decode($fila['materia']),1,0,'L',1);
							$this->pdf->Cell(7,$a,'P',1,0,'C',1);
							$this->pdf->Cell(35,$a,'PENDIENTE',1,0,'L',1);
							$this->pdf->Cell(7,$a,utf8_decode('R'),1,0,'C',1);
							$this->pdf->Cell(7,$a,utf8_decode($fila['mes']),1,0,'C',1);
							$this->pdf->Cell(7,$a,utf8_decode($fila['anio']),1,0,'C',1);
							$this->pdf->Cell(12,$a,utf8_decode($this->saber_escuela($escuelasforaneas,$fila['idescuelaforanea'])),1,0,'C',1);
						}else{
							$this->pdf->SetX($h);
							$this->pdf->Cell(57,$a,utf8_decode($fila['materia']),1,0,'L',1);
							$this->pdf->Cell(7,$a,utf8_decode($fila['nota']),1,0,'C',1);
							$this->pdf->Cell(35,$a,utf8_decode($this->sabernota($fila['nota'])),1,0,'L',1);
							$this->pdf->Cell(7,$a,utf8_decode($fila['tipo']),1,0,'C',1);
							$this->pdf->Cell(7,$a,utf8_decode($fila['mes']),1,0,'C',1);
							$this->pdf->Cell(7,$a,utf8_decode($fila['anio']),1,0,'C',1);
							$this->pdf->Cell(12,$a,utf8_decode($this->saber_escuela($escuelasforaneas,$fila['idescuelaforanea'])),1,0,'C',1);

						}
						$this->pdf->Ln();
						$x+=1;
					}

				}
				for($x=$x;$x<17;$x++) //CODIGO MATERIAS
				{
					$this->pdf->SetX($h);
					$this->pdf->Cell(57,$a,utf8_decode(""),1,0,'L',1);
					$this->pdf->Cell(7,$a,utf8_decode(""),1,0,'L',1);
					$this->pdf->Cell(35,$a,utf8_decode(""),1,0,'C',1);
					$this->pdf->Cell(7,$a,utf8_decode(""),1,0,'C',1);
					$this->pdf->Cell(7,$a,utf8_decode(""),1,0,'C',1);
					$this->pdf->Cell(7,$a,utf8_decode(""),1,0,'C',1);
					$this->pdf->Cell(12,$a,utf8_decode(""),1,0,'C',1);
					$this->pdf->Ln();
				}


			}

			$this->pdf->SetX($h);
			$this->pdf->SetFont('Arial','',$l);
			$this->pdf->Cell(115,$a,utf8_decode("VIII. Programas Aprobados en Educación Para el Trabajo: GRADO / NOMBRE / HORAS ALUMNO SEMANAL"),0,0,'L',0);


			$this->pdf->SetX($h);
			$this->pdf->SetFont('Arial','',$l);

			for($i=0;$i<count($materiaset);$i++)
			{
				if($i%2==0){$this->pdf->Ln();$this->pdf->SetX($h);}
				$materiaet=explode(',',$materiaset[$i]);
				$this->pdf->Cell(8,$a,$materiaet[0],1,0,'C',1);
				$this->pdf->Cell(84,$a,$materiaet[1],1,0,'L',1);
				$this->pdf->Cell(8,$a,$materiaet[2],1,0,'C',1);
			}
			$this->pdf->Ln();

			$this->pdf->Ln();
			$this->pdf->SetX($h);
			$this->pdf->SetFont('Arial','',$l);
			$this->pdf->Cell(22,$a,'IX. Observaciones:',0,0,'L',0);
			$this->pdf->Cell(178,$a,'','B',0,'L',0);
			$this->pdf->Ln();
			$this->pdf->SetX($h);
			$this->pdf->Cell(200,$a,'','B',0,'L',0);
			$this->pdf->Ln();
			$this->pdf->SetX($h);
			$this->pdf->Cell(200,$a,'','B',0,'L',0);
			$this->pdf->Ln();
			$this->pdf->SetX($h);
			$this->pdf->Cell(200,$a,'','B',0,'L',0);
			$this->pdf->Ln();
			$this->pdf->SetX($h);
			$this->pdf->Cell(200,$a,'','B',0,'L',0);
			$this->pdf->Ln();
			$this->pdf->SetX($h);
			$this->pdf->Cell(200,$a,'','B',0,'L',0);
			$this->pdf->Ln();
			$this->pdf->SetX($h);
			$this->pdf->Cell(200,$a,'','B',0,'L',0);
			$this->pdf->Ln();

			$this->pdf->Ln((-7*$a));
			$this->pdf->SetX($h+22);
			$this->pdf->MultiCell(170,$a,implode(', ',$observaciones));

			$this->pdf->SetXY($h,342);
			$this->pdf->SetFont('Arial','',$l);
			$this->pdf->Cell(40,$a,utf8_decode('X. Lugar y Fecha de Expedición:'),0,0,'L',0);
			$this->pdf->Cell(160,$a,'EN '.$municipio_escuela.' EL '.date('d').' DE '.$this->sabermes(date('m')).' DE '.date('Y').'','B',0,'L',0);
			$this->pdf->Ln();
			$this->pdf->SetX($h);
			$this->pdf->SetFont('Arial','',($l-2));
			$this->pdf->Cell(30,($a-1),utf8_decode('Timbre Fiscal: Este Documento no tiene validez si no se le colocan en la parte posterior timbres fiscales por Bs. 30% de la U.T.'),0,0,'L',0);
			$h=142;
			$this->pdf->SetY(77);
			$this->pdf->SetX($h);
			$this->pdf->SetFont('Arial','',$l);
			$this->pdf->Cell(66,$a,'VI. Plantel',1,0,'C',0);
			$this->pdf->Ln();
			$this->pdf->SetX($h);
			$this->pdf->Cell(66,$a,'Apellidos y Nombres','LR',0,'L',0);
			$this->pdf->Ln();
			$this->pdf->SetX($h);
			$this->pdf->Cell(66,$a,'del Director(a)','LR',0,'L',0);
			$this->pdf->Ln();
			$this->pdf->SetX($h);
			$this->pdf->Cell(66,($a*2),$director_escuela,1,0,'C',0);
			$this->pdf->Ln();
			$this->pdf->SetX($h);
			$this->pdf->Cell(66,$a,utf8_decode('Número de C.I.:'),1,0,'L',0);
			$this->pdf->Ln();
			$this->pdf->SetX($h);
			$this->pdf->Cell(66,$a,$ceduladirector_escuela,1,0,'C',0);
			$this->pdf->Ln();
			$this->pdf->SetX($h);
			$this->pdf->Cell(66,$a,'Firma',1,0,'L',0);
			$this->pdf->Ln();
			$this->pdf->SetX($h);
			$this->pdf->Cell(66,($a*2),'',1,0,'L',0);
			$this->pdf->Ln();
			$this->pdf->SetX($h);
			$this->pdf->Cell(66,$a*14,'SELLO DEL PLANTEL',1,0,'C',0);
			$this->pdf->Ln();
			$this->pdf->SetX($h);
			$this->pdf->Cell(66,$a,'Para Efectos de su Validez','LR',0,'C',0);
			$this->pdf->Ln();
			$this->pdf->SetX($h);
			$this->pdf->Cell(66,$a,'a nivel estadal','LR',0,'C',0);
			$this->pdf->Ln();
			$this->pdf->SetX($h);
			$this->pdf->Cell(66,$a,'','LR',0,'C',0);
			$this->pdf->Ln();
			$this->pdf->SetX($h);
			$this->pdf->Cell(66,$a,'VII. Zona Educativa',1,0,'C',0);
			$this->pdf->Ln();
			$this->pdf->SetX($h);
			$this->pdf->Cell(66,$a,'Apellidos y Nombres','LR',0,'L',0);
			$this->pdf->Ln();
			$this->pdf->SetX($h);
			$this->pdf->Cell(66,$a,'del Director(a)','LR',0,'L',0);
			$this->pdf->Ln();
			$this->pdf->SetX($h);
			$this->pdf->Cell(66,($a*2),'',1,0,'C',0);
			$this->pdf->Ln();
			$this->pdf->SetX($h);
			$this->pdf->Cell(66,$a,utf8_decode('Número de C.I.:'),1,0,'L',0);
			$this->pdf->Ln();
			$this->pdf->SetX($h);
			$this->pdf->Cell(66,$a,'',1,0,'C',0);
			$this->pdf->Ln();
			$this->pdf->SetX($h);
			$this->pdf->Cell(66,$a,'Firma',1,0,'L',0);
			$this->pdf->Ln();
			$this->pdf->SetX($h);
			$this->pdf->Cell(66,($a*2),'',1,0,'L',0);
			$this->pdf->Ln();
			$this->pdf->SetX($h);
			$this->pdf->Cell(66,$a*14,'SELLO DE LA ZONA EDUCATIVA',1,0,'C',0);
			$this->pdf->Ln();
			$this->pdf->SetX($h);
			$this->pdf->Cell(66,$a,'Para Efectos de su Validez a nivel','LR',0,'C',0);
			$this->pdf->Ln();
			$this->pdf->SetX($h);
			$this->pdf->Cell(66,$a,'nacional e internacional y cuando se','LR',0,'C',0);
			$this->pdf->Ln();
			$this->pdf->SetX($h);
			$this->pdf->Cell(66,$a,'trate de estudis libres o equivalentes','LR',0,'C',0);
			$this->pdf->Ln();
			$this->pdf->SetX($h);
			$this->pdf->Cell(66,$a,'sin escolaridad','LR',0,'C',0);
			$this->pdf->Ln();
			$this->pdf->SetX($h);
			$this->pdf->Cell(66,$a,'','LR',0,'C',0);
			$this->pdf->Ln();
			$this->pdf->SetX($h);
			$this->pdf->Cell(66,$a,'','LRB',0,'C',0);
			$this->pdf->Output("NotasCertificada.pdf", 'I');

		}else{
			show_error('No tienes permiso para realizar está función. Por Favor contacte con el administrador', 403, $heading = 'Acceso Denegado');
		}
	}

	public function rep_usuarios($id=null)
	{
		if($this->usuarios->autorizacion('rep_usuarios')){
			if($this->session->userdata['tipousuario']=='administrador'){
				$this->pdf->SetFillColor(255,255,255);
				$this->load->model('usuarios');
				$this->pdf->AddPage();
				$this->pdf->AliasNbPages();
				$this->pdf->SetTitle("Lista de Usuarios");
				$this->pdf->SetFont('Arial','UB',10);
				$this->pdf->Cell(190,5,'Listado de Usuarios',0,0,'C',0);
				$this->pdf->Ln(10);

				$this->pdf->SetFont('Arial','I',9);
				$this->SetWidths(array(10,55,55,20,25,25));
				$this->SetAligns(array('C','L','C','C','C','C'));
				$this->Row(array('Nro','Nombre','email','Estatus','Tipo','Registro'));
				$x = 1;
				if($this->usuarios->lista_usuarios())
				{
					$rs_usuarios = $this->usuarios->lista_usuarios();
					foreach ($rs_usuarios->result_array() as $fila)
					{
						if($fila['activo']==1){
							$fila['activo']='Activo';
						}else{
							$fila['activo']='Inactivo';
						}
						$this->Row(array($x++,$fila['nombre'],$fila['email'],$fila['activo'],$fila["descripcion"],nice_date($fila["fechaHora"],'d-m-Y')));
					}
				}
				$this->pdf->Output("Lista de Usuarios.pdf", 'I');
			}else{
					show_error('No tienes permiso para realizar está función. Por Favor contacte con el administrador', 403, $heading = 'Acceso Denegado');
			}
		}
	}


}
