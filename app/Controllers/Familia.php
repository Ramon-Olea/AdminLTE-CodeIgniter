<?php

namespace App\Controllers;

use App\Models\Familias;
use App\Models\Splinet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Hermawan\DataTables\src\DataTables;
use Hermawan\DataTables\DataTable;

class Familia extends BaseController
{

    public function familias()
    {
        if (session('usuario')) { //si existe una session activa manda a la vista si no manda el login

            return view('familias/inicio');
        } else {

            return redirect()->to(base_url('/'))->with('mensaje', 'Ingresa al sistema');
        }
    }

    public function detalleFamiliaOptronics()
    {
        return view('familias/detalleFamiliaOptronics');
    }
    public function detalleFamiliaFibremex()
    {
        return view('familias/detalleFamiliaFibremex');
    }
    public function detalleFamiliaSplittel()
    {
        return view('familias/detalleFamiliaSplittel');
    }

    /* DASHBOARD */
    public function dashboard()
    {
        if (session('usuario')) { //si existe una session activa manda a la vista si no manda el login

            return view('dashboard/inicio');
        } else {

            return redirect()->to(base_url('/'))->with('mensaje', 'Ingresa al sistema');
        }
    }

    public function FamiliaSplittel()
    {
        return view('dashboard/FamiliaSplittel');
    }

    public function FamiliaFibremex()
    {
        return view('dashboard/FamiliaFibremex');
    }

    public function FamiliaOptronics()
    {
        return view('dashboard/FamiliaOptronics');
    }

    public function FamiliaFibremex80()
    {
        return view('dashboard/FamiliaFibremex80');
    }
    public function FamiliaFibremex15()
    {
        return view('dashboard/FamiliaFibremex15');
    }
    public function FamiliaFibremex5()
    {
        return view('dashboard/FamiliaFibremex5');
    }
    public function FamiliaOptronics80()
    {
        return view('dashboard/FamiliaOptronics80');
    }
    public function FamiliaOptronics15()
    {
        return view('dashboard/FamiliaOptronics15');
    }
    public function FamiliaOptronics5()
    {
        return view('dashboard/FamiliaOptronics5');
    }

    public function TablaFibremex80()
    {
        return view('dashboard/TablaFibremex80');
    }

    public function TablaFibremex15()
    {
        return view('dashboard/TablaFibremex15');
    }

    public function TablaFibremex5()
    {
        return view('dashboard/TablaFibremex5');
    }
    public function TablaOptro80()
    {
        return view('dashboard/TablaOptro80');
    }

    public function TablaOptro15()
    {
        return view('dashboard/TablaOptro15');
    }

    public function TablaOptro5()
    {
        return view('dashboard/TablaOptro5');
    }
    public function TablaSplittel80()
    {
        return view('dashboard/TablaSplittel80');
    }

    public function TablaSplittel15()
    {
        return view('dashboard/TablaSplittel15');
    }

    public function TablaSplittel5()
    {
        return view('dashboard/TablaSplittel5');
    }

    /* KPIS  🆁🅼🅽  */

    public function Kpis()
    {
        if (session('usuario')) { //si existe una session activa manda a la vista si no manda el login
            $DataSplinet = new Splinet();
            $datakpis = $DataSplinet->listarkpis();
            $data = [
                'kpis' =>  $datakpis
            ];
            return view('kpis/inicio', $data);
        } else {

            return redirect()->to(base_url('/'))->with('mensaje', 'Ingresa al sistema');
        }
    }
    public function kpis_indicadores_ajax()
    {
        /*   */
        $DataSplinet = new Splinet();
        $datakpis = $DataSplinet->listarIndicadores($_REQUEST['id']);
        /*     print_r($datakpis );
        exit;  */
        // Realiza la consulta o procesamiento necesario para obtener los datos
        // Convierte los datos a HTML
        $html = '';
        foreach ($datakpis as $dato) {

            $html .= '<a class="list-group-item list-group-item-action " id="list-home-list" data-bs-toggle="list" href="#list-home' . $dato->id . '" role="tab" aria-controls="list-home">' . $dato->descripcion . '</a> ';
        }

        // Devuelve la respuesta en formato HTML
        return $html;
    }
    /* END KPIS */



    /* pleaneacion  🆁🅼🅽  */

    public function Planeacion()
    {
        if (session('usuario')) { //si existe una session activa manda a la vista si no manda el login
            /*  $DataSplinet = new Splinet();
          $datakpis = $DataSplinet->listarkpis();
          $data = [
              'kpis' =>  $datakpis
          ]; */
            return view('Planeacion/inicio');
        } else {

            return redirect()->to(base_url('/'))->with('mensaje', 'Ingresa al sistema');
        }
    }

    public function vista2()
    {
        if (session('usuario')) { //si existe una session activa manda a la vista si no manda el login
            return view('Planeacion/vista2',);
        } else {

            return redirect()->to(base_url('/'))->with('mensaje', 'Ingresa al sistema');
        }
    }
    public function PlaneacionV2()
    {
        if (session('usuario')) { //si existe una session activa manda a la vista si no manda el login
            return view('Planeacion/vista2',);
        } else {

            return redirect()->to(base_url('/'))->with('mensaje', 'Ingresa al sistema');
        }
    }
    public function vista2serverside()
    {
        $DataSplinet = new Splinet();
        $datakpis = $DataSplinet->Vista2($_POST['familia']);

        $datakpisss = $DataSplinet->Vistaw($datakpis);
        $ConsultaServerside = $DataSplinet->ConsultaInnerServerside();
        return  DataTable::of($ConsultaServerside)->edit('column1', function ($row) {
            return '<a href="#" data-bs-toggle="modal" id="boton2" class="text-white" data-bs-target="#SPLI" data-id="' . $row->column1 . '" data-id2="' . $row->column3 . '">' . $row->column1 . '</a></td>
            ';
        })->toJson();
    }
    public function detalleAcumuladoVentas()
    {
        $DataSplinet = new Splinet();
        $datakpis = $DataSplinet->VENTAS_FIBREMEX();
        $PFIBRE = $DataSplinet->PORCENTAJE_FIBREMEX();
        $POPTRO = $DataSplinet->PORCENTAJE_OPTRONICS();
      /*   print_r($_POST);
exit; */
        $dato = [
            'data' => $datakpis,
            'dFibre' => $PFIBRE,
            'dOptro' => $POPTRO,

        ];
        /*    print_r( $dato);exit; */
        return view('Planeacion/detalleAcumuladoVentas', $dato);
    }
    public function ServerSideListV2()
    {
        return view('Planeacion/ServerSideListV2');
    }
    public function PlaneacionF()
    {
        if (session('usuario')) { //si existe una session activa manda a la vista si no manda el login
            /*  $DataSplinet = new Splinet();
          $datakpis = $DataSplinet->listarkpis();
          $data = [
              'kpis' =>  $datakpis
          ]; */
            return view('Planeacion/inicio');
        } else {

            return redirect()->to(base_url('/'))->with('mensaje', 'Ingresa al sistema');
        }
    }
    public function EmailPlaneacion()
    {
        $Home = new Familia(); //envia el correo 
        /*   $Home->SendEmailPlaneacion(); //envia el correo  */

        return view('Planeacion/EmailPlaneacion');
    }
    public function EmailPlaneacionTarea()
    {
        $Home = new Familia(); //envia el correo 
        /*   $Home->SendEmailPlaneacion(); //envia el correo  */

        return view('Planeacion/EmailPlaneacionTarea');
    }
    public function ServerSideList()
    {
        return view('Planeacion/ServerSideList');
    }
    public function SendEmailPlaneacion()
    {
        // Ruta del archivo Excel
        $rutaArchivo = 'tendencia.xlsx';










        // Cargar el archivo Excel
        $spreadsheet = IOFactory::load($rutaArchivo);
        $DataSplinet = new Splinet();

        // Obtener la hoja de cálculo activa
        $worksheet = $spreadsheet->getActiveSheet();

        $mesActual = date('n'); // Devuelve un número del 1 al 12
        $añoActual = date('Y');

        // Array con los nombres de los meses en español
        $nombresMeses = array(
            'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio',
            'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'
        );


        $columna = 'D'; // Iniciar en la columna 'D' o cualquier otra columna deseada
        for ($i = $mesActual - 12; $i <= $mesActual - 1; $i++) {
            $mes = ($i < 1) ? $i + 12 : $i; // Manejo circular de los meses
            $año = ($i < 1) ? $añoActual - 1 : $añoActual;
            $celda = $columna . '1'; // Construir la referencia de la celda
            $valor = $nombresMeses[$mes - 1] . " " . $año;
            $worksheet->setCellValue($celda, $valor);
            $columna++;
        }

        /* // Mostrar el mes actual
        $valorP =  $nombresMeses[$mesActual - 1] . " " . $añoActual;

        $worksheet->setCellValue('P1', $valorP);
        // Mostrar los siguientes 9 meses */
        $columna2 = 'p'; // Iniciar en la columna 'D' o cualquier otra columna deseada

        for ($i = $mesActual + 1; $i <= $mesActual + 9; $i++) {
            $mes = ($i - 1) % 12; // Manejo circular de los meses
            $año = $añoActual;
            if ($mes < $mesActual) {
                $año++; // Si el mes es anterior al actual, incrementamos el año
            }
            $celda = $columna2 . '1'; // Construir la referencia de la celda
            $valor = $nombresMeses[$mes - 1] . " " . $año;
            $worksheet->setCellValue($celda, $valor);
            $columna2++;
        }










        $row = 3; // Fila inicial para insertar datos
        $count = 0; // Variable de conteo
        $sads = $DataSplinet->TENDENCIA12MESES();
        // Fetch the data and count the total records
        $data = array();
        $tendencia = array();

        while ($row1 = odbc_fetch_array($sads)) {

            // Aquí puedes agregar más filas de datos según tus necesidades
            $y = [$row1['Mes-12'], $row1['Mes-11'], $row1['Mes-10'], $row1['Mes-9'], $row1['Mes-8'], $row1['Mes-7'], $row1['Mes-6'], $row1['Mes-5'], $row1['Mes-4'], $row1['Mes-3'], $row1['Mes-2'], $row1['Mes-1']];
            // Valor específico de x para el cual se desea calcular la línea de tendencia

            $array1 = $DataSplinet->TENDENCIAR($y);
            /*             $array2 = [$row1['Codigo'], $row1['Descripcion'], $row1['Familia'],$row1['Mes-12'], $row1['Mes-11'], $row1['Mes-10'], $row1['Mes-9'], $row1['Mes-8'], $row1['Mes-7'], $row1['Mes-6'], $row1['Mes-5'], $row1['Mes-4'], $row1['Mes-3'], $row1['Mes-2'], $row1['Mes-1']];;
 */
            $array2 = [$row1['Codigo'], $row1['Descripcion'], $row1['Familia'], number_format($row1['Mes-12'], 0), number_format($row1['Mes-11'], 0), number_format($row1['Mes-10'], 0), number_format($row1['Mes-9'], 0), number_format($row1['Mes-8'], 0), number_format($row1['Mes-7'], 0), number_format($row1['Mes-6'], 0), number_format($row1['Mes-5'], 0), number_format($row1['Mes-4'], 0), number_format($row1['Mes-3'], 0), number_format($row1['Mes-2'], 0), number_format($row1['Mes-1'], 0)];;

            $mesActual = date('n');
            $suma  = 0; //array();
            $Tsuma  = array();
            $Psuma  = array();
            $Csuma  = array();
            $E  = array();
            $total = 0;
            $cantidad = 0;
            $promedio = 0;
            // Calcula el total de meses que faltan para terminar el año
            $mesesRestantes = 12 - $mesActual;

            // Calcula el total de meses anteriores al mes actual
            $mesesAnteriores = $mesActual - 1;
            // Acceder a las posiciones menores a $mesesAnteriores
            for ($i = $mesesAnteriores; $i <= 11; $i++) {
                $suma += $y[$i];

                $E[] =  $y[$i];
            }


            // Acceder a las posiciones mayores a $mesesRestantes
            for ($i = 13; $i < 12 + $mesActual; $i++) {
                $suma + $array1[$i];
                $E[] =  $array1[$i];
            }
            foreach ($E as $value) {
                $value = str_replace(',', '', $value); // Eliminar las comas de los valores
                $total += (float) $value; // Convertir el valor a float y sumarlo al total
            }

            $promedio = ($total / 12);
            $Tsuma[] = number_format($promedio, 0);

            $cantidad =  ($promedio * 9);
            $disponible = (isset($row1['Disponible']) ? ($cantidad -  $row1['Disponible']) : 0);
            $Psuma[] =  number_format($cantidad, 0);
            $Csuma[] =  number_format($disponible, 0);;

            $ArrayTendencia = [$array1[12], $array1[13], $array1[14], $array1[15], $array1[16], $array1[17], $array1[18], $array1[19], $array1[20]];
            if ($disponible > 0) {
                $mergedArray = array_merge($array2, $ArrayTendencia, $Tsuma, $Psuma, $Csuma);
                /*  print_r($mergedArray);
            exit;  */
                $data[] = array_values($mergedArray);
            }
        }
        /*         $data[] = ['sdfdsf', 'sdfsdf', 'sdfdsf', 'sdfdsf', 'sdfsdf', 'sdfdsf', 'sdfdsf', 'sdfsdf', 'sdfdsf', 'sdfdsf', 'sdfsdf', 'sdfdsf', 'sdfdsf', 'sdfsdf', 'sdfdsf', 'ffdgfg', 'ewrererewr', 'zxczxvxv'];
 */
        /* 	print_r($array2['Disponible']);
                exit; */
        foreach ($data as $rowData) {
            $col = 'A';
            foreach ($rowData as $cellData) {
                $worksheet->setCellValue($col . $row, $cellData);
                $col++;
            }
            $row++;
        }
        $count++;

        // Guardar el archivo Excel modificado
        $writer = new Xlsx($spreadsheet);
        $nuevaRutaArchivo = 'tendencia.xlsx';
        $writer->save($nuevaRutaArchivo);

        // Descargar el archivo Excel modificado
        /*  $this->response->download($nuevaRutaArchivo, null)->setFileName('sample.xlsx'); */



        /* manda el correo con el archivo excel modificado */
        $email = \Config\Services::email();
        $correo = session('email') != "" ? session('email') : "aaron.cuevas@splittel.com";
        $email->setFrom('notificaciones-splitnet@splittel.com', 'SISTEMA AI-ML');
        $email->setTo($correo);
        $email->setBCC(['ramon.olea@splittel.com', 'aaron.cuevas@splittel.com', 'miguel.rosiles@splittel.com']);

        /*  $email->setCC('another@another-example.com');
        $email->setBCC('them@their-example.com'); */
        $html = view('Planeacion/TemplateEmail');
        $email->setSubject('Revision de tendencias de productos');
        $email->setMessage($html);
        $email->attach('tendencia.xlsx');
        if ($email->send()) {
            return print_r('<div class="alert alert-success alert-dismissable fade show p-3 text-center">
            <h4 class="alert-heading">ENVIADO!</h4>
            <p>INFORMACION ENVIADA AL CORREO</p>
          
          </div>');
        } else {
            return print_r('<div class="alert alert-danger alert-dismissable fade show p-3 text-center">
            <h4 class="alert-heading">ERROR!</h4>
            <p>ERROR AL ENVIAR EL CORREO INTENTE DE NUEVO</p>
            <hr />
            <p class="mb-0">Whenever you need to, be sure to use margin utilities to keep things nice and tidy.</p>
          </div>');
        };
    }

    public function SendEmailPlaneacionTarea()
    {
        // Ruta del archivo Excel
        $rutaArchivo = 'tendencia.xlsx';

        // Cargar el archivo Excel
        $spreadsheet = IOFactory::load($rutaArchivo);
        $DataSplinet = new Splinet();

        // Obtener la hoja de cálculo activa
        $worksheet = $spreadsheet->getActiveSheet();

        $mesActual = date('n'); // Devuelve un número del 1 al 12
        $añoActual = date('Y');

        // Array con los nombres de los meses en español
        $nombresMeses = array(
            'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio',
            'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'
        );


        $columna = 'D'; // Iniciar en la columna 'D' o cualquier otra columna deseada
        for ($i = $mesActual - 12; $i <= $mesActual - 1; $i++) {
            $mes = ($i < 1) ? $i + 12 : $i; // Manejo circular de los meses
            $año = ($i < 1) ? $añoActual - 1 : $añoActual;
            $celda = $columna . '1'; // Construir la referencia de la celda
            $valor = $nombresMeses[$mes - 1] . " " . $año;
            $worksheet->setCellValue($celda, $valor);
            $columna++;
        }

        /* // Mostrar el mes actual
        $valorP =  $nombresMeses[$mesActual - 1] . " " . $añoActual;

        $worksheet->setCellValue('P1', $valorP);
        // Mostrar los siguientes 9 meses */
        $columna2 = 'p'; // Iniciar en la columna 'D' o cualquier otra columna deseada

        for ($i = $mesActual + 1; $i <= $mesActual + 9; $i++) {
            $mes = ($i - 1) % 12; // Manejo circular de los meses
            $año = $añoActual;
            if ($mes < $mesActual) {
                $año++; // Si el mes es anterior al actual, incrementamos el año
            }
            $celda = $columna2 . '1'; // Construir la referencia de la celda
            $valor = $nombresMeses[$mes - 1] . " " . $año;
            $worksheet->setCellValue($celda, $valor);
            $columna2++;
        }










        $row = 3; // Fila inicial para insertar datos
        $count = 0; // Variable de conteo
        $sads = $DataSplinet->TENDENCIA12MESES();
        // Fetch the data and count the total records
        $data = array();
        $tendencia = array();

        while ($row1 = odbc_fetch_array($sads)) {

            // Aquí puedes agregar más filas de datos según tus necesidades
            $y = [$row1['Mes-12'], $row1['Mes-11'], $row1['Mes-10'], $row1['Mes-9'], $row1['Mes-8'], $row1['Mes-7'], $row1['Mes-6'], $row1['Mes-5'], $row1['Mes-4'], $row1['Mes-3'], $row1['Mes-2'], $row1['Mes-1']];
            // Valor específico de x para el cual se desea calcular la línea de tendencia

            $array1 = $DataSplinet->TENDENCIAR($y);
            /*             $array2 = [$row1['Codigo'], $row1['Descripcion'], $row1['Familia'],$row1['Mes-12'], $row1['Mes-11'], $row1['Mes-10'], $row1['Mes-9'], $row1['Mes-8'], $row1['Mes-7'], $row1['Mes-6'], $row1['Mes-5'], $row1['Mes-4'], $row1['Mes-3'], $row1['Mes-2'], $row1['Mes-1']];;
 */
            $array2 = [$row1['Codigo'], $row1['Descripcion'], $row1['Familia'], number_format($row1['Mes-12'], 0), number_format($row1['Mes-11'], 0), number_format($row1['Mes-10'], 0), number_format($row1['Mes-9'], 0), number_format($row1['Mes-8'], 0), number_format($row1['Mes-7'], 0), number_format($row1['Mes-6'], 0), number_format($row1['Mes-5'], 0), number_format($row1['Mes-4'], 0), number_format($row1['Mes-3'], 0), number_format($row1['Mes-2'], 0), number_format($row1['Mes-1'], 0)];;

            $mesActual = date('n');
            $suma  = 0; //array();
            $Tsuma  = array();
            $Psuma  = array();
            $Csuma  = array();
            $E  = array();
            $total = 0;
            $cantidad = 0;
            $promedio = 0;
            // Calcula el total de meses que faltan para terminar el año
            $mesesRestantes = 12 - $mesActual;

            // Calcula el total de meses anteriores al mes actual
            $mesesAnteriores = $mesActual - 1;
            // Acceder a las posiciones menores a $mesesAnteriores
            for ($i = $mesesAnteriores; $i <= 11; $i++) {
                $suma += $y[$i];

                $E[] =  $y[$i];
            }


            // Acceder a las posiciones mayores a $mesesRestantes
            for ($i = 13; $i < 12 + $mesActual; $i++) {
                $suma + $array1[$i];
                $E[] =  $array1[$i];
            }
            foreach ($E as $value) {
                $value = str_replace(',', '', $value); // Eliminar las comas de los valores
                $total += (float) $value; // Convertir el valor a float y sumarlo al total
            }

            $promedio = ($total / 12);
            $Tsuma[] = number_format($promedio, 0);

            $cantidad =  ($promedio * 9);
            $disponible = (isset($row1['Disponible']) ? ($cantidad -  $row1['Disponible']) : 0);
            $Psuma[] =  number_format($cantidad, 0);
            $Csuma[] =  number_format($disponible, 0);;

            $ArrayTendencia = [$array1[12], $array1[13], $array1[14], $array1[15], $array1[16], $array1[17], $array1[18], $array1[19], $array1[20]];
            if ($disponible > 0) {
                $mergedArray = array_merge($array2, $ArrayTendencia, $Tsuma, $Psuma, $Csuma);
                /*  print_r($mergedArray);
            exit;  */
                $data[] = array_values($mergedArray);
            }
        }
        /*         $data[] = ['sdfdsf', 'sdfsdf', 'sdfdsf', 'sdfdsf', 'sdfsdf', 'sdfdsf', 'sdfdsf', 'sdfsdf', 'sdfdsf', 'sdfdsf', 'sdfsdf', 'sdfdsf', 'sdfdsf', 'sdfsdf', 'sdfdsf', 'ffdgfg', 'ewrererewr', 'zxczxvxv'];
 */
        /* 	print_r($array2['Disponible']);
                exit; */
        foreach ($data as $rowData) {
            $col = 'A';
            foreach ($rowData as $cellData) {
                $worksheet->setCellValue($col . $row, $cellData);
                $col++;
            }
            $row++;
        }
        $count++;

        // Guardar el archivo Excel modificado
        $writer = new Xlsx($spreadsheet);
        $nuevaRutaArchivo = 'tendencia.xlsx';
        $writer->save($nuevaRutaArchivo);

        // Descargar el archivo Excel modificado
        /*  $this->response->download($nuevaRutaArchivo, null)->setFileName('sample.xlsx'); */



        /* manda el correo con el archivo excel modificado */
        $email = \Config\Services::email();

        $email->setFrom('notificaciones-splitnet@splittel.com', 'SISTEMA AI-ML');
        $email->setTo('ramon.olea@splittel.com');
        $email->setBCC(['ramon.olea@splittel.com', 'aaron.cuevas@splittel.com', 'miguel.rosiles@splittel.com']);
        /*  $email->setCC('miguel.rosiles@splittel.com'); */

        /*  $email->setCC('another@another-example.com');
        $email->setBCC('them@their-example.com'); */
        $html = view('Planeacion/TemplateEmail');
        $email->setSubject('Revision de tendencias de productos');
        $email->setMessage($html);
        $email->attach('tendencia.xlsx');
        if ($email->send()) {
            return print_r('<div class="alert alert-success alert-dismissable fade show p-3 text-center">
            <h4 class="alert-heading">ENVIADO!</h4>
            <p>INFORMACION ENVIADA AL CORREO</p>
          
          </div>');
        } else {
            return print_r('<div class="alert alert-danger alert-dismissable fade show p-3 text-center">
            <h4 class="alert-heading">ERROR!</h4>
            <p>ERROR AL ENVIAR EL CORREO INTENTE DE NUEVO</p>
            <hr />
            <p class="mb-0">Whenever you need to, be sure to use margin utilities to keep things nice and tidy.</p>
          </div>');
        };
    }
}
