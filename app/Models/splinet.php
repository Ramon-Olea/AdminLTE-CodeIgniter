<?php

namespace App\Models;

use CodeIgniter\Model;

class Splinet extends Model
{
    protected $db;
    protected $sap;

    public function __construct()
    {
        $this->db = db_connect('SPLINET');
    }


    public function listarkpis()
    {

        $Investigacion = $this->db->query('select * from kpis_planes');
        return $Investigacion->getResult();
    }
    public function listarIndicadores($id)
    {

        $Investigacion = $this->db->query('select * from kpis_indicadores where activo ="Si" and id_plan =' . $id . ' ');
        return $Investigacion->getResult();
    }
    public function insertar($data)
    {
        $Investigacion = $this->db->table('ficables');
        $Investigacion->insert($data);

        return $this->db->insertID();
    }
    public function actualizar($data, $articulo)
    {
        $Investigacion = $this->db->table('ficables');
        $Investigacion->set($data);
        $Investigacion->where('id', $articulo);

        return $Investigacion->update();
    }
    public function obtener($data)
    {
        $Usuario = $this->db->table('ficables');
        $Usuario->where($data);
        return $Usuario->get()->getResultArray();
    }

    public function TENDENCIAR($y)
    {
        $Tendencia = array();

        $x = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        for ($i = 1; $i <= 21; $i++) {

            // Calcular la media de x e y
            $meanX = array_sum($x) / count($x);
            $meanY = array_sum($y) / count($y);

            // Calcular las sumas de los productos y los cuadrados
            $sumXY = 0;
            $sumXX = 0;
            foreach ($x as $key => $value) {
                $sumXY += ($value - $meanX) * ($y[$key] - $meanY);
                $sumXX += ($value - $meanX) * ($value - $meanX);
            }
            $X = $i;
            // Calcular la pendiente y la intersección de la línea de tendencia
            $slope = $sumXY / $sumXX;
            $intercept = $meanY - $slope * $meanX;
            $Tendencia[] = $intercept + ($slope * $X);
        }

        // Imprimir los resultados
        /* 	echo "Pendiente: " . $slope . "\n";
            echo "Intersección: " . $intercept . "\n";
            echo "Valor predicho para $X: $predictedY"; */
        return    $data[] = array_values($Tendencia);
    }

    public function TENDENCIA12MESES()
    {

        $datasource = 'DRIVER=HDBODBC;SERVERNODE=192.168.2.19:30015;CHAR_AS_UTF8=1;';
        $username   = "USR_LECTURA";
        $password   = "SPL.Lectura202xx";

        $conn   = odbc_connect($datasource, $username, $password, SQL_CUR_USE_ODBC);

        $sql = 'SELECT Final."Proveedor", Final."NombreProveedor", Final."Codigo", Final."Descripcion", Final."Familia", Final."SubFamilia",
Final."Mes-12", Final."Mes-11", Final."Mes-10", Final."Mes-9", Final."Mes-8",Final."Mes-7",
Final."Mes-6",Final."Mes-5", Final."Mes-4",Final."Mes-3",Final."Mes-2",Final."Mes-1",
final."Stock", final."Comprometido", final."Solicitado", 
(final."Stock" - Final."Comprometido" + Final."Solicitado") AS "Disponible"

FROM (
		SELECT T25."CardCode" AS "Proveedor", 
		(SELECT "CardName" FROM HN_FIBREMEX.OCRD WHERE T25."CardCode" = "CardCode") AS "NombreProveedor",  
		T25."ItemCode" AS "Codigo", T25."ItemName" AS "Descripcion",
		(SELECT T500."Mes-12" FROM HN_FIBREMEX."MRP_Meses_DAT_VIEW" T500 WHERE T500."ItemCode" = T25."ItemCode") "Mes-12",
		(SELECT T500."Mes-11" FROM HN_FIBREMEX."MRP_Meses_DAT_VIEW" T500 WHERE T500."ItemCode" = T25."ItemCode") "Mes-11",
		(SELECT T500."Mes-10" FROM HN_FIBREMEX."MRP_Meses_DAT_VIEW" T500 WHERE T500."ItemCode" = T25."ItemCode") "Mes-10",
		(SELECT T500."Mes-9" FROM HN_FIBREMEX."MRP_Meses_DAT_VIEW" T500 WHERE T500."ItemCode" = T25."ItemCode") "Mes-9",
		(SELECT T500."Mes-8" FROM HN_FIBREMEX."MRP_Meses_DAT_VIEW" T500 WHERE T500."ItemCode" = T25."ItemCode") "Mes-8",
		(SELECT T500."Mes-7" FROM HN_FIBREMEX."MRP_Meses_DAT_VIEW" T500 WHERE T500."ItemCode" = T25."ItemCode") "Mes-7",
		(SELECT T500."Mes-6" FROM HN_FIBREMEX."MRP_Meses_DAT_VIEW" T500 WHERE T500."ItemCode" = T25."ItemCode") "Mes-6",
		(SELECT T500."Mes-5" FROM HN_FIBREMEX."MRP_Meses_DAT_VIEW" T500 WHERE T500."ItemCode" = T25."ItemCode") "Mes-5",      
		(SELECT T500."Mes-4" FROM HN_FIBREMEX."MRP_Meses_DAT_VIEW" T500 WHERE T500."ItemCode" = T25."ItemCode") "Mes-4",
		(SELECT T500."Mes-3" FROM HN_FIBREMEX."MRP_Meses_DAT_VIEW" T500 WHERE T500."ItemCode" = T25."ItemCode") "Mes-3",
		(SELECT T500."Mes-2" FROM HN_FIBREMEX."MRP_Meses_DAT_VIEW" T500 WHERE T500."ItemCode" = T25."ItemCode") "Mes-2",
		(SELECT T500."Mes-1" FROM HN_FIBREMEX."MRP_Meses_DAT_VIEW" T500 WHERE T500."ItemCode" = T25."ItemCode") "Mes-1",
		  
	
		(SELECT SUM(T100."OnHand") FROM HN_FIBREMEX.OITW T100 WHERE T100."WhsCode" IN (\'NORIA\',\'CEDIS\') AND T100."ItemCode" = T25."ItemCode") AS "Stock",
		 (SELECT SUM(T0."IsCommited") 
			FROM HN_FIBREMEX.OITW T0 
			INNER JOIN HN_FIBREMEX.OITM T1 ON T0."ItemCode" = T1."ItemCode" 
			WHERE T0."WhsCode" <> \'ALMCUARE\' AND T1."validFor" = \'Y\' AND T25."ItemCode" = t0."ItemCode") AS "Comprometido",
		 (SELECT SUM(T0."OnOrder") 
			FROM HN_FIBREMEX.OITW T0 
			INNER JOIN HN_FIBREMEX.OITM T1 ON T0."ItemCode" = T1."ItemCode" 
			WHERE T0."WhsCode" <> \'ALMCUARE\' AND T1."validFor" = \'Y\' AND T25."ItemCode" = t0."ItemCode") AS "Solicitado",	 
		(SELECT T48."ItmsGrpNam" FROM HN_FIBREMEX.OITB T48 WHERE T48."ItmsGrpCod" = T25."ItmsGrpCod") AS "Familia",
		T25."U_SubFamilia" "SubFamilia"
 
	 FROM HN_FIBREMEX.OITM T25
	 WHERE T25."InvntItem" = \'Y\' AND T25."validFor" = \'Y\' AND T25."frozenFor" = \'N\'
) AS Final';

        $result = odbc_exec($conn, $sql);
        return $result;
    }

    public function Vista2($familia)
    {
        $datasource = 'DRIVER=HDBODBC;SERVERNODE=192.168.2.19:30015;CHAR_AS_UTF8=1;';
        $username   = "USR_LECTURA";
        $password   = "SPL.Lectura202xx";

        $conn   = odbc_connect($datasource, $username, $password, SQL_CUR_USE_ODBC);

        $variable = isset($familia) && $familia != "" ? $familia : "";
        $where =  isset($familia) && $familia != "" ? 'WHERE Final."Familia" IN  (\'' . $variable . '\')' : "";
        /* FIN CONEXION A SAP */
        if ($conn === false) {
            die("Connection failed: " . odbc_errormsg());
        }

        // Get the request parameters from DataTables
        /* $start = $_POST['start'];
        $length = $_POST['length'];
        $searchValue = $_POST['search']['value'];
        $orderByColumnIndex = $_POST['order'][0]['column'];
        $orderByColumn = $_POST['columns'][$orderByColumnIndex]['data'];
        $orderByDirection = $_POST['order'][0]['dir']; */

        // Construct the SQL query

        $sql = 'SELECT Final."Proveedor", Final."NombreProveedor", Final."Codigo", Final."Descripcion", Final."Familia", Final."SubFamilia",
        Final."Mes-12", Final."Mes-11", Final."Mes-10", Final."Mes-9", Final."Mes-8",Final."Mes-7",
        Final."Mes-6",Final."Mes-5", Final."Mes-4",Final."Mes-3",Final."Mes-2",Final."Mes-1",
        final."Stock", final."Comprometido", final."Solicitado", 
        (final."Stock" - Final."Comprometido" + Final."Solicitado") AS "Disponible"
        
        FROM (
                SELECT T25."CardCode" AS "Proveedor", 
                (SELECT "CardName" FROM  HN_FIBREMEX.OCRD WHERE T25."CardCode" = "CardCode") AS "NombreProveedor",  
                T25."ItemCode" AS "Codigo", T25."ItemName" AS "Descripcion",
                (SELECT T500."Mes-12" FROM HN_FIBREMEX."MRP_Meses_DAT_VIEW" T500 WHERE T500."ItemCode" = T25."ItemCode") "Mes-12",
                (SELECT T500."Mes-11" FROM HN_FIBREMEX."MRP_Meses_DAT_VIEW" T500 WHERE T500."ItemCode" = T25."ItemCode") "Mes-11",
                (SELECT T500."Mes-10" FROM HN_FIBREMEX."MRP_Meses_DAT_VIEW" T500 WHERE T500."ItemCode" = T25."ItemCode") "Mes-10",
                (SELECT T500."Mes-9" FROM HN_FIBREMEX."MRP_Meses_DAT_VIEW" T500 WHERE T500."ItemCode" = T25."ItemCode") "Mes-9",
                (SELECT T500."Mes-8" FROM HN_FIBREMEX."MRP_Meses_DAT_VIEW" T500 WHERE T500."ItemCode" = T25."ItemCode") "Mes-8",
                (SELECT T500."Mes-7" FROM HN_FIBREMEX."MRP_Meses_DAT_VIEW" T500 WHERE T500."ItemCode" = T25."ItemCode") "Mes-7",
                (SELECT T500."Mes-6" FROM HN_FIBREMEX."MRP_Meses_DAT_VIEW" T500 WHERE T500."ItemCode" = T25."ItemCode") "Mes-6",
                (SELECT T500."Mes-5" FROM HN_FIBREMEX."MRP_Meses_DAT_VIEW" T500 WHERE T500."ItemCode" = T25."ItemCode") "Mes-5",      
                (SELECT T500."Mes-4" FROM HN_FIBREMEX."MRP_Meses_DAT_VIEW" T500 WHERE T500."ItemCode" = T25."ItemCode") "Mes-4",
                (SELECT T500."Mes-3" FROM HN_FIBREMEX."MRP_Meses_DAT_VIEW" T500 WHERE T500."ItemCode" = T25."ItemCode") "Mes-3",
                (SELECT T500."Mes-2" FROM HN_FIBREMEX."MRP_Meses_DAT_VIEW" T500 WHERE T500."ItemCode" = T25."ItemCode") "Mes-2",
                (SELECT T500."Mes-1" FROM HN_FIBREMEX."MRP_Meses_DAT_VIEW" T500 WHERE T500."ItemCode" = T25."ItemCode") "Mes-1",
                  
            
                (SELECT SUM(T100."OnHand") FROM  HN_FIBREMEX.OITW T100 WHERE T100."WhsCode" IN (\'NORIA\',\'CEDIS\') AND T100."ItemCode" = T25."ItemCode") AS "Stock",
                 (SELECT SUM(T0."IsCommited") 
                    FROM  HN_FIBREMEX.OITW T0 
                    INNER JOIN  HN_FIBREMEX.OITM T1 ON T0."ItemCode" = T1."ItemCode" 
                    WHERE T0."WhsCode" <> \'ALMCUARE\' AND T1."validFor" = \'Y\' AND T25."ItemCode" = t0."ItemCode") AS "Comprometido",
                 (SELECT SUM(T0."OnOrder") 
                    FROM  HN_FIBREMEX.OITW T0 
                    INNER JOIN  HN_FIBREMEX.OITM T1 ON T0."ItemCode" = T1."ItemCode" 
                    WHERE T0."WhsCode" <> \'ALMCUARE\' AND T1."validFor" = \'Y\' AND T25."ItemCode" = t0."ItemCode") AS "Solicitado",	 
                (SELECT T48."ItmsGrpNam" FROM  HN_FIBREMEX.OITB T48 WHERE T48."ItmsGrpCod" = T25."ItmsGrpCod") AS "Familia",
                T25."U_SubFamilia" "SubFamilia"
         
             FROM HN_FIBREMEX.OITM T25
             WHERE T25."InvntItem" = \'Y\' AND T25."validFor" = \'Y\' AND T25."frozenFor" = \'N\' 
             
        ) AS Final   ' . $where . '
        ';
        /* print_r($sql);
        exit; */
        $result = odbc_exec($conn, $sql);

        // Fetch the data and count the total records  
        $data = array();
        $tendencia = array();


        while ($row = odbc_fetch_array($result)) {

            $y = [$row['Mes-12'], $row['Mes-11'], $row['Mes-10'], $row['Mes-9'], $row['Mes-8'], $row['Mes-7'], $row['Mes-6'], $row['Mes-5'], $row['Mes-4'], $row['Mes-3'], $row['Mes-2'], $row['Mes-1']];
            // Valor específico de x para el cual se desea calcular la línea de tendencia

            $array1 =  $this->TENDENCIAR($y);
            /* $array2 = $row; */
            //MES ANTERIORES AL MES 12 NO PONER LA TENDENCIA SOLO PONER LA VENTA ACTUAL 
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
            /*  */
            $disponible = (isset($row['Disponible']) ? ($cantidad -  $row['Disponible']) : 0);
            $Psuma[] =  number_format($cantidad, 0);
            $Csuma[] =  number_format($disponible, 0);;

            $array2 = [$row['Codigo'], $row['Descripcion'], $row['Familia'], $row['SubFamilia'], number_format($row['Mes-12'], 0), number_format($row['Mes-11'], 0), number_format($row['Mes-10'], 0), number_format($row['Mes-9'], 0), number_format($row['Mes-8'], 0), number_format($row['Mes-7'], 0), number_format($row['Mes-6'], 0), number_format($row['Mes-5'], 0), number_format($row['Mes-4'], 0), number_format($row['Mes-3'], 0), number_format($row['Mes-2'], 0), number_format($row['Mes-1'], 0)];;
            $ArrayTendencia = [$array1[12], $array1[13], $array1[14], $array1[15], $array1[16], $array1[17], $array1[18], $array1[19], $array1[20]];
            $array3 = [number_format($row['Stock'], 0), number_format($row['Comprometido'], 0), number_format($row['Solicitado'], 0), number_format($row['Disponible'], 0)];
            $mergedArray = array_merge($array2, $ArrayTendencia, $Tsuma, $Psuma, $Csuma, $array3);

            /* $mergedArray = array_merge($array2, $array1, $Tsuma, $Psuma, $Csuma); */
            $data[] = array_values($mergedArray);
        }

        /*     $RMN = array(

            'data' => $data
        
        ); */


        // Return the JSON response
        return ($data);
    }


    public function Vistaw($dataArray)
    {
        // Eliminar la tabla temporal si existe
        /*     $this->query("DROP TABLE IF EXISTS temp_table"); */

        // Crear la tabla temporal
        $this->db->query('CREATE TEMPORARY TABLE temp_table (
            column1 VARCHAR(255),
            column2 VARCHAR(255),
            column3 VARCHAR(255),
            column4 VARCHAR(255),
            column5 INT,
            column6 INT,
            column7 INT,
            column8 INT,
            column9 INT,
            column10 INT,
            column11 INT,
            column12 INT,
            column13 INT,
            column14 INT,
            column15 INT,
            column16 FLOAT,
            column17 FLOAT,
            column18 FLOAT,
            column19 FLOAT,
            column20 FLOAT,
            column21 FLOAT,
            column22 FLOAT,
            column23 FLOAT,
            column24 FLOAT,
            column25 INT,
            column26 INT,
            column27 INT,
            column28 INT,
            column29 INT,
            column30 INT,
            column31 INT,
            column32 INT
          )');
        foreach ($dataArray as $data) {

            $this->db->query("INSERT INTO temp_table (column1, column2, column3, column4, column5, column6, column7, column8, column9, column10, column11, column12, column13, column14, column15, column16, column17, column18, column19, column20, column21, column22, column23, column24, column25, column26, column27, column28, column29, column30, column31, column32) 
            VALUES ('" . implode("','", $data) . "')");
        }
    }
    public function ConsultaInnerServerside()
    {
        return  $this->db->table('temp_table t')->select('column1, column2, column3, column4, column5, column6, column7, column8, column9, column10, column11, column12, column13, column14, column15, column16, column17, column18, column19, column20, column21, column22, column23, column24, column25, column26, column27, column28, column29, column30, column31, column32');
    }
    function db_SAP($query)
    {

        /* CONEXION A SAP */
        $datasource = 'DRIVER=HDBODBC;SERVERNODE=192.168.2.19:30015;CHAR_AS_UTF8=1;';
        $username   = "USR_LECTURA";
        $password   = "SPL.Lectura202xx";

        $conn   = odbc_connect($datasource, $username, $password, SQL_CUR_USE_ODBC);
        /* FIN CONEXION A SAP */
        return  odbc_exec($conn, $query);
    }
    function VENTAS_FIBREMEX()  /* VENTAS  */
    { //Funcion manda consultas y ejecuta 
        $familia = $_POST['Familia'];
        $codigo = $_POST['Codigo'];




        $datasource = 'DRIVER=HDBODBC;SERVERNODE=192.168.2.19:30015;CHAR_AS_UTF8=1;';
        $username   = "USR_LECTURA";
        $password   = "SPL.Lectura202xx";

        $conn   = odbc_connect($datasource, $username, $password, SQL_CUR_USE_ODBC);
        $sql = ('SELECT Final."Codigo", Final."Descripcion", Final."Familia",  Final."SubFamilia",
     CASE WHEN Final."Ventas2019" IS NULL THEN 0 ELSE Final."Ventas2019" END AS "dieznueve",
    CASE WHEN Final."Ventas2020" IS NULL THEN 0 ELSE Final."Ventas2020" END AS "veinte",
  CASE WHEN Final."Ventas2021" IS NULL THEN 0 ELSE Final."Ventas2021" END AS "veinteuno",
  CASE WHEN Final."AcumuladoVentas2022" IS NULL THEN 0 ELSE Final."AcumuladoVentas2022" END AS "veintedos"


FROM (
  SELECT T25."CardCode" AS "Proveedor", (SELECT "CardName" FROM HN_FIBREMEX.OCRD WHERE T25."CardCode" = "CardCode") AS "NombreProveedor",
  (SELECT "GroupCode" FROM HN_FIBREMEX.OCRD WHERE T25."CardCode" = "CardCode") AS "Grupo",
  T25."ItemCode" AS "Codigo", T25."ItemName" AS "Descripcion", T25."U_SubFamilia" "SubFamilia",
  
  
   /*		ACUMULADO DE VENTAS 2019	>>>>**PIEZAS**<<<<	*/            
        (SELECT SUM(Acumulado."Cantidad") 
       FROM (
           SELECT
               CASE WHEN T0.CANCELED = \'C\' THEN (T1."Quantity" * -1) ELSE (T1."Quantity") END AS "Cantidad" 
             FROM HN_FIBREMEX.OINV T0 
             INNER JOIN HN_FIBREMEX.INV1 T1 ON T0."DocEntry" = T1."DocEntry" 
             INNER JOIN HN_FIBREMEX.OSLP T2 ON T0."SlpCode" = T2."SlpCode" 
             INNER JOIN HN_FIBREMEX.OITM T3 ON T1."ItemCode" = T3."ItemCode" 
             LEFT OUTER JOIN HN_FIBREMEX.OCRD T4 ON T3."CardCode" = T4."CardCode" 
             INNER JOIN HN_FIBREMEX.OITB T5 ON T5."ItmsGrpCod" = T3."ItmsGrpCod"
             WHERE YEAR(T0."DocDate") = YEAR(NOW()) -4
                  AND T1."ItemCode" = T25."ItemCode" AND T1."ItemCode" = \'' . $codigo . '\'
AND T5."ItmsGrpNam" = \'' . $familia . '\' 
   UNION ALL 
           SELECT 
               CASE WHEN T0.CANCELED = \'C\' THEN (T1."Quantity") ELSE (T1."Quantity" * -1) END AS "Cantidad" 
             FROM HN_FIBREMEX.ORIN T0 
             INNER JOIN HN_FIBREMEX.RIN1 T1 ON T0."DocEntry" = T1."DocEntry" 
             INNER JOIN HN_FIBREMEX.OSLP T2 ON T0."SlpCode" = T2."SlpCode" 
             INNER JOIN HN_FIBREMEX.OITM T3 ON T1."ItemCode" = T3."ItemCode" 
             LEFT OUTER JOIN HN_FIBREMEX.OCRD T4 ON T3."CardCode" = T4."CardCode" 
             INNER JOIN HN_FIBREMEX.OITB T5 ON T5."ItmsGrpCod" = T3."ItmsGrpCod"
             WHERE YEAR(T0."DocDate") = YEAR(NOW()) -4
                  AND t1."BaseType" <> \'203\' AND T1."ItemCode" = T25."ItemCode" AND T1."ItemCode" = \'' . $codigo . '\'
AND T5."ItmsGrpNam" = \'' . $familia . '\' 
             ) AS Acumulado
   ) AS "Ventas2019",
   
/*		ACUMULADO DE VENTAS 2020	>>>>**PIEZAS**<<<<	*/            
        (SELECT SUM(Acumulado."Cantidad") 
       FROM (
           SELECT
               CASE WHEN T0.CANCELED = \'C\' THEN (T1."Quantity" * -1) ELSE (T1."Quantity") END AS "Cantidad" 
             FROM HN_FIBREMEX.OINV T0 
             INNER JOIN HN_FIBREMEX.INV1 T1 ON T0."DocEntry" = T1."DocEntry" 
             INNER JOIN HN_FIBREMEX.OSLP T2 ON T0."SlpCode" = T2."SlpCode" 
             INNER JOIN HN_FIBREMEX.OITM T3 ON T1."ItemCode" = T3."ItemCode" 
             LEFT OUTER JOIN HN_FIBREMEX.OCRD T4 ON T3."CardCode" = T4."CardCode" 
             INNER JOIN HN_FIBREMEX.OITB T5 ON T5."ItmsGrpCod" = T3."ItmsGrpCod"
             WHERE YEAR(T0."DocDate") = YEAR(NOW()) -3
                  AND T1."ItemCode" = T25."ItemCode"  AND T1."ItemCode" = \'' . $codigo . '\'
AND T5."ItmsGrpNam" = \'' . $familia . '\' 
   UNION ALL 
           SELECT 
               CASE WHEN T0.CANCELED = \'C\' THEN (T1."Quantity") ELSE (T1."Quantity" * -1) END AS "Cantidad" 
             FROM HN_FIBREMEX.ORIN T0 
             INNER JOIN HN_FIBREMEX.RIN1 T1 ON T0."DocEntry" = T1."DocEntry" 
             INNER JOIN HN_FIBREMEX.OSLP T2 ON T0."SlpCode" = T2."SlpCode" 
             INNER JOIN HN_FIBREMEX.OITM T3 ON T1."ItemCode" = T3."ItemCode" 
             LEFT OUTER JOIN HN_FIBREMEX.OCRD T4 ON T3."CardCode" = T4."CardCode" 
             INNER JOIN HN_FIBREMEX.OITB T5 ON T5."ItmsGrpCod" = T3."ItmsGrpCod"
             WHERE YEAR(T0."DocDate") = YEAR(NOW()) -3
                  AND t1."BaseType" <> \'203\' AND T1."ItemCode" = T25."ItemCode" AND T1."ItemCode" = \'' . $codigo . '\'
AND T5."ItmsGrpNam" = \'' . $familia . '\' 
             ) AS Acumulado
   ) AS "Ventas2020",
      
/*		ACUMULADO DE VENTAS 2021	>>>>**PIEZAS**<<<<	*/            
        (SELECT SUM(Acumulado."Cantidad") 
       FROM (
           SELECT
               CASE WHEN T0.CANCELED = \'C\' THEN (T1."Quantity" * -1) ELSE (T1."Quantity") END AS "Cantidad" 
             FROM HN_FIBREMEX.OINV T0 
             INNER JOIN HN_FIBREMEX.INV1 T1 ON T0."DocEntry" = T1."DocEntry" 
             INNER JOIN HN_FIBREMEX.OSLP T2 ON T0."SlpCode" = T2."SlpCode" 
             INNER JOIN HN_FIBREMEX.OITM T3 ON T1."ItemCode" = T3."ItemCode" 
             LEFT OUTER JOIN HN_FIBREMEX.OCRD T4 ON T3."CardCode" = T4."CardCode" 
             INNER JOIN HN_FIBREMEX.OITB T5 ON T5."ItmsGrpCod" = T3."ItmsGrpCod"
             WHERE YEAR(T0."DocDate") = YEAR(NOW()) -2
                  AND T1."ItemCode" = T25."ItemCode"  AND T1."ItemCode" = \'' . $codigo . '\'
AND T5."ItmsGrpNam" = \'' . $familia . '\' 
   UNION ALL 
           SELECT 
               CASE WHEN T0.CANCELED = \'C\' THEN (T1."Quantity") ELSE (T1."Quantity" * -1) END AS "Cantidad" 
             FROM HN_FIBREMEX.ORIN T0 
             INNER JOIN HN_FIBREMEX.RIN1 T1 ON T0."DocEntry" = T1."DocEntry" 
             INNER JOIN HN_FIBREMEX.OSLP T2 ON T0."SlpCode" = T2."SlpCode" 
             INNER JOIN HN_FIBREMEX.OITM T3 ON T1."ItemCode" = T3."ItemCode" 
             LEFT OUTER JOIN HN_FIBREMEX.OCRD T4 ON T3."CardCode" = T4."CardCode" 
             INNER JOIN HN_FIBREMEX.OITB T5 ON T5."ItmsGrpCod" = T3."ItmsGrpCod"
             WHERE YEAR(T0."DocDate") = YEAR(NOW()) -2
                  AND t1."BaseType" <> \'203\' AND T1."ItemCode" = T25."ItemCode" AND T1."ItemCode" = \'' . $codigo . '\'
AND T5."ItmsGrpNam" = \'' . $familia . '\' 
             ) AS Acumulado
   ) AS "Ventas2021",
   
   /*		ACUMULADO DE VENTAS 2022	>>>>**PIEZAS**<<<<	*/   
        (SELECT SUM(Acumulado."Cantidad") 
       FROM (
           SELECT
               CASE WHEN T0.CANCELED = \'C\' THEN (T1."Quantity" * -1) ELSE (T1."Quantity") END AS "Cantidad" 
             FROM HN_FIBREMEX.OINV T0 
             INNER JOIN HN_FIBREMEX.INV1 T1 ON T0."DocEntry" = T1."DocEntry" 
             INNER JOIN HN_FIBREMEX.OSLP T2 ON T0."SlpCode" = T2."SlpCode" 
             INNER JOIN HN_FIBREMEX.OITM T3 ON T1."ItemCode" = T3."ItemCode" 
             LEFT OUTER JOIN HN_FIBREMEX.OCRD T4 ON T3."CardCode" = T4."CardCode" 
             INNER JOIN HN_FIBREMEX.OITB T5 ON T5."ItmsGrpCod" = T3."ItmsGrpCod"
             WHERE YEAR(T0."DocDate") = YEAR(NOW()) -1
                  AND T1."ItemCode" = T25."ItemCode" AND T1."ItemCode" = \'' . $codigo . '\'
AND T5."ItmsGrpNam" = \'' . $familia . '\' 
   UNION ALL 
           SELECT 
                CASE WHEN T0.CANCELED = \'C\' THEN (T1."Quantity") ELSE (T1."Quantity" * -1) END AS "Cantidad" 
             FROM HN_FIBREMEX.ORIN T0 
             INNER JOIN HN_FIBREMEX.RIN1 T1 ON T0."DocEntry" = T1."DocEntry" 
             INNER JOIN HN_FIBREMEX.OSLP T2 ON T0."SlpCode" = T2."SlpCode" 
             INNER JOIN HN_FIBREMEX.OITM T3 ON T1."ItemCode" = T3."ItemCode" 
             LEFT OUTER JOIN HN_FIBREMEX.OCRD T4 ON T3."CardCode" = T4."CardCode" 
             INNER JOIN HN_FIBREMEX.OITB T5 ON T5."ItmsGrpCod" = T3."ItmsGrpCod"
             WHERE YEAR(T0."DocDate") = YEAR(NOW()) -1 
                  AND t1."BaseType" <> \'203\' AND T1."ItemCode" = T25."ItemCode" AND T1."ItemCode" = \'' . $codigo . '\'
AND T5."ItmsGrpNam" = \'' . $familia . '\' 
             ) AS Acumulado
   ) AS "AcumuladoVentas2022",
         
        
      (SELECT T48."ItmsGrpNam" FROM HN_FIBREMEX.OITB T48 WHERE T48."ItmsGrpCod" = T25."ItmsGrpCod") AS "Familia"

       
              
  FROM HN_FIBREMEX."OITM" T25
  INNER JOIN HN_FIBREMEX.OITB T26 ON T26."ItmsGrpCod" = T25."ItmsGrpCod"

  WHERE T25."SellItem" = \'Y\' 
  AND T25."ItemCode" = \'' . $codigo . '\'
  AND T26."ItmsGrpNam" = \'' . $familia . '\' ) AS Final 
  ORDER BY 1
');
        /*   print_r($sql);
        exit; */
        $consulta = odbc_exec($conn, $sql);
        return  odbc_fetch_array($consulta);
    }









    function PORCENTAJE_OPTRONICS()  /* VENTAS  */
    { //Funcion manda consultas y ejecuta 
        $codigo = $_POST['Codigo'];




        $datasource = 'DRIVER=HDBODBC;SERVERNODE=192.168.2.19:30015;CHAR_AS_UTF8=1;';
        $username   = "USR_LECTURA";
        $password   = "SPL.Lectura202xx";

        $conn   = odbc_connect($datasource, $username, $password, SQL_CUR_USE_ODBC);
        $sql = ('SELECT Vtas."Año" "Año", 
		CASE WHEN Vtas."Año" = YEAR(NOW()) -4 THEN Vtas."Cot Pz19" WHEN Vtas."Año" = YEAR(NOW()) -3 THEN Vtas."Cot Pz20" WHEN Vtas."Año" = YEAR(NOW()) -2 THEN Vtas."Cot Pz21" 
			 WHEN Vtas."Año" = YEAR(NOW()) -1 THEN Vtas."Cot Pz22" WHEN Vtas."Año" = YEAR(NOW()) THEN Vtas."Cot Pz23" END AS "Cot Pz",
		CASE WHEN Vtas."Año" = YEAR(NOW()) -4 THEN Vtas."Cot Doc19" WHEN Vtas."Año" = YEAR(NOW()) -3 THEN Vtas."Cot Doc20" WHEN Vtas."Año" = YEAR(NOW()) -2 THEN Vtas."Cot Doc21"
			 WHEN Vtas."Año" = YEAR(NOW()) -1 THEN Vtas."Cot Doc22" WHEN Vtas."Año" = YEAR(NOW()) THEN Vtas."Cot Doc23" END AS "Cot Doc",		
		CASE WHEN Vtas."Año" = YEAR(NOW()) -4 THEN Vtas."Ventas19" WHEN Vtas."Año" = YEAR(NOW()) -3 THEN Vtas."Ventas20" WHEN Vtas."Año" = YEAR(NOW()) -2 THEN Vtas."Ventas21"
			 WHEN Vtas."Año" = YEAR(NOW()) -1 THEN Vtas."Ventas22" WHEN Vtas."Año" = YEAR(NOW()) THEN Vtas."Ventas23" END AS "Ventas",			 
		CASE WHEN Vtas."Año" = YEAR(NOW()) -4 THEN Vtas."Fac Doc19" WHEN Vtas."Año" = YEAR(NOW()) -3 THEN Vtas."Fac Doc20" WHEN Vtas."Año" = YEAR(NOW()) -2 THEN Vtas."Fac Doc21"
			 WHEN Vtas."Año" = YEAR(NOW()) -1 THEN Vtas."Fac Doc22" WHEN Vtas."Año" = YEAR(NOW()) THEN Vtas."Fac Doc23" END AS "Fac Doc",			 
		CASE WHEN Vtas."Año" = YEAR(NOW()) -4 THEN Vtas."CantidadDeClientes2019" WHEN Vtas."Año" = YEAR(NOW()) -3 THEN Vtas."CantidadDeClientes2020" WHEN Vtas."Año" = YEAR(NOW()) -2 THEN Vtas."CantidadDeClientes2021" 
		 	 WHEN Vtas."Año" = YEAR(NOW()) -1 THEN Vtas."CantidadDeClientes2022" WHEN Vtas."Año" = YEAR(NOW()) THEN Vtas."CantidadDeClientes2023" END AS "Clientes",
		CASE WHEN Vtas."Año" = YEAR(NOW()) -4 THEN ROUND((Vtas."Ventas19" / Vtas."Cot Pz19")* 100,2)WHEN Vtas."Año" = YEAR(NOW()) -3 THEN ROUND((Vtas."Ventas20" / Vtas."Cot Pz20") * 100,2)
			 WHEN Vtas."Año" = YEAR(NOW()) -2 THEN ROUND((Vtas."Ventas21" / Vtas."Cot Pz21") * 100,2)WHEN Vtas."Año" = YEAR(NOW()) -1 THEN ROUND((Vtas."Ventas22" / Vtas."Cot Pz22") * 100,2)  
			 WHEN Vtas."Año" = YEAR(NOW()) THEN ROUND((Vtas."Ventas23" / Vtas."Cot Pz23") * 100,2) END AS "PorcentajeConversion"
FROM(
		SELECT DISTINCT YEAR(T2."DocDate") AS "Año",
				(SELECT SUM(Vtas."Cantidad1")
					 FROM(
						SELECT T1."Quantity" "Cantidad1"
						FROM  HN_OPTRONICS.OQUT T0
						INNER JOIN HN_OPTRONICS.QUT1 T1 ON T0."DocEntry" = T1."DocEntry" 
						WHERE  YEAR(T0."DocDate") = YEAR(NOW()) -4 AND T1."ItemCode" = \'' . $codigo . '\'
					)Vtas
				)AS "Cot Pz19",
		
		(SELECT COUNT(DISTINCT(T2."DocNum")) 
						FROM   HN_OPTRONICS.OQUT T2 
						INNER JOIN HN_OPTRONICS.QUT1 T1 ON T2."DocEntry" = T1."DocEntry" WHERE   YEAR(T2."DocDate") = YEAR(NOW()) -4
						AND T1."ItemCode" = \'' . $codigo . '\'
				)AS "Cot Doc19",
				
		(SELECT SUM(Ventas."Cantidad1")
FROM(
		SELECT CASE WHEN T0.CANCELED = \'C\' THEN (T1."Quantity"*-1) ELSE (T1."Quantity") END AS "Cantidad1" 
					FROM HN_OPTRONICS.OINV T0
					INNER JOIN HN_OPTRONICS.INV1 T1 ON T0."DocEntry" = T1."DocEntry" 
					WHERE   YEAR(T0."DocDate") = YEAR(NOW()) -4 AND T1."ItemCode" = \'' . $codigo . '\'
					
					UNION ALL 
					
		SELECT CASE WHEN T0.CANCELED = \'C\' THEN (T1."Quantity") ELSE (T1."Quantity" * -1) END AS "Cantidad1" 
					FROM HN_OPTRONICS.ORIN T0
					INNER JOIN HN_OPTRONICS.RIN1 T1 ON T0."DocEntry" = T1."DocEntry" 
					WHERE  T1."BaseType" <> \'203\'  AND  YEAR(T0."DocDate") = YEAR(NOW()) -4 AND T1."ItemCode" = \'' . $codigo . '\'
					)Ventas
					) AS "Ventas19",
		(SELECT COUNT(DISTINCT(Doc."Documento"))
					FROM
					(SELECT T2."DocNum" "Documento" 
						FROM HN_OPTRONICS.OINV T2 
						INNER JOIN HN_OPTRONICS.INV1 T1 ON T2."DocEntry" = T1."DocEntry" WHERE   YEAR(T2."DocDate") = YEAR(NOW()) -4
						AND T1."ItemCode" = \'' . $codigo . '\' 
						
						UNION ALL
						
						SELECT T2."DocNum" "Documento"  
						FROM HN_OPTRONICS.ORIN T2 
						INNER JOIN HN_OPTRONICS.RIN1 T1 ON T2."DocEntry" = T1."DocEntry" WHERE   YEAR(T2."DocDate") = YEAR(NOW()) -4 AND  T1."BaseType" <> \'203\' 
						AND T1."ItemCode" = \'' . $codigo . '\'
				)Doc
				)AS "Fac Doc19",		
		(SELECT SUM(VentasClientes."CantClientes")
 FROM(
	 	 SELECT CASE WHEN T0.CANCELED = \'C\' THEN COUNT(DISTINCT(T0."CardName")) * -1 ELSE COUNT(DISTINCT(T0."CardName")) END AS "CantClientes"
			FROM HN_OPTRONICS.OINV T0 
			INNER JOIN HN_OPTRONICS.INV1 T1 ON T0."DocEntry" = T1."DocEntry" 
			INNER JOIN HN_OPTRONICS.OITM T3 ON T1."ItemCode" = T3."ItemCode" 
			INNER JOIN HN_OPTRONICS.OITB T4 ON T4."ItmsGrpCod" = T3."ItmsGrpCod" 
			INNER JOIN HN_OPTRONICS.OSLP T5 ON T0."SlpCode" = T5."SlpCode" 
			WHERE  YEAR(T0."DocDate") = YEAR(NOW()) -4 AND T1."ItemCode" = \'' . $codigo . '\'
			GROUP BY T0.CANCELED
UNION ALL  
		 SELECT CASE WHEN T0.CANCELED = \'C\' THEN COUNT(DISTINCT(T0."CardName"))* -1  ELSE COUNT(DISTINCT(T0."CardName"))  END AS "CantClientes"
			FROM HN_OPTRONICS.ORIN T0 
			INNER JOIN HN_OPTRONICS.RIN1 T1 ON T0."DocEntry" = T1."DocEntry" 
			INNER JOIN HN_OPTRONICS.OITM T3 ON T1."ItemCode" = T3."ItemCode" 
			INNER JOIN HN_OPTRONICS.OITB T4 ON T4."ItmsGrpCod" = T3."ItmsGrpCod" 
			INNER JOIN HN_OPTRONICS.OSLP T5 ON T0."SlpCode" = T5."SlpCode" 
			WHERE   YEAR(T0."DocDate") = YEAR(NOW()) -4 AND T1."BaseType" <> \'203\'  AND T1."ItemCode" = \'' . $codigo . '\'
			GROUP BY T0.CANCELED
)VentasClientes) AS "CantidadDeClientes2019",
------------------------------------------AÑO 2020--------------------------------------------
	(SELECT SUM(Vtas."Cantidad1")
				 FROM(
					SELECT T1."Quantity" "Cantidad1"
					FROM   HN_OPTRONICS.OQUT T0
					INNER JOIN HN_OPTRONICS.QUT1 T1 ON T0."DocEntry" = T1."DocEntry" 
					WHERE YEAR(T0."DocDate") = YEAR(NOW()) -3 AND T1."ItemCode" = \'' . $codigo . '\'
				)Vtas
			)AS "Cot Pz20",
	
			(SELECT COUNT(DISTINCT(T2."DocNum")) 
					FROM  HN_OPTRONICS.OQUT T2 
					INNER JOIN HN_OPTRONICS.QUT1 T1 ON T2."DocEntry" = T1."DocEntry" WHERE  YEAR(T2."DocDate") = YEAR(NOW()) -3
					AND T1."ItemCode" = \'' . $codigo . '\'
			)AS "Cot Doc20",
				
	(SELECT SUM(Ventas."Cantidad1")
FROM(
	SELECT CASE WHEN T0.CANCELED = \'C\' THEN (T1."Quantity"*-1) ELSE (T1."Quantity") END AS "Cantidad1" 
				FROM HN_OPTRONICS.OINV T0
				INNER JOIN HN_OPTRONICS.INV1 T1 ON T0."DocEntry" = T1."DocEntry" 
				WHERE   YEAR(T0."DocDate") = YEAR(NOW()) -3 AND T1."ItemCode" = \'' . $codigo . '\'
				
				UNION ALL 
				
	SELECT CASE WHEN T0.CANCELED = \'C\' THEN (T1."Quantity") ELSE (T1."Quantity" * -1) END AS "Cantidad1" 
				FROM HN_OPTRONICS.ORIN T0
				INNER JOIN HN_OPTRONICS.RIN1 T1 ON T0."DocEntry" = T1."DocEntry" 
				WHERE  T1."BaseType" <> \'203\'  AND YEAR(T0."DocDate") = YEAR(NOW()) -3 AND T1."ItemCode" = \'' . $codigo . '\'
				)Ventas
				) AS "Ventas20",
	
	(SELECT COUNT(DISTINCT(Doc."Documento"))
	 		FROM
			(SELECT T2."DocNum" "Documento" 
				FROM HN_OPTRONICS.OINV T2 
				INNER JOIN HN_OPTRONICS.INV1 T1 ON T2."DocEntry" = T1."DocEntry" WHERE YEAR(T2."DocDate") = YEAR(NOW()) -3 
				AND T1."ItemCode" = \'' . $codigo . '\'
				
				UNION ALL
				
				SELECT T2."DocNum" "Documento"  
				FROM HN_OPTRONICS.ORIN T2 
				INNER JOIN HN_OPTRONICS.RIN1 T1 ON T2."DocEntry" = T1."DocEntry" WHERE YEAR(T2."DocDate") = YEAR(NOW()) -3 AND  T1."BaseType" <> \'203\' 
				AND T1."ItemCode" =  \'' . $codigo . '\'
		)Doc
		)AS "Fac Doc20",
		
	(SELECT SUM(VentasClientes."CantClientes")
 FROM (SELECT CASE WHEN T0.CANCELED = \'C\' THEN COUNT(DISTINCT(T0."CardName")) * -1 ELSE COUNT(DISTINCT(T0."CardName")) END AS "CantClientes"
		FROM HN_OPTRONICS.OINV T0 
		INNER JOIN HN_OPTRONICS.INV1 T1 ON T0."DocEntry" = T1."DocEntry" 
		INNER JOIN HN_OPTRONICS.OITM T3 ON T1."ItemCode" = T3."ItemCode" 
		INNER JOIN HN_OPTRONICS.OITB T4 ON T4."ItmsGrpCod" = T3."ItmsGrpCod" 
		INNER JOIN HN_OPTRONICS.OSLP T5 ON T0."SlpCode" = T5."SlpCode" 
		WHERE YEAR(T0."DocDate") = YEAR(NOW()) -3 AND T1."ItemCode" = \'' . $codigo . '\'
		GROUP BY T0.CANCELED
UNION ALL  
	SELECT CASE WHEN T0.CANCELED = \'C\' THEN COUNT(DISTINCT(T0."CardName"))* -1  ELSE COUNT(DISTINCT(T0."CardName"))  END AS "CantClientes"
		FROM HN_OPTRONICS.ORIN T0 
		INNER JOIN HN_OPTRONICS.RIN1 T1 ON T0."DocEntry" = T1."DocEntry" 
		INNER JOIN HN_OPTRONICS.OITM T3 ON T1."ItemCode" = T3."ItemCode" 
		INNER JOIN HN_OPTRONICS.OITB T4 ON T4."ItmsGrpCod" = T3."ItmsGrpCod" 
		INNER JOIN HN_OPTRONICS.OSLP T5 ON T0."SlpCode" = T5."SlpCode" 
		WHERE YEAR(T0."DocDate") = YEAR(NOW()) -3 AND T1."BaseType" <> \'203\'  AND T1."ItemCode" =  \'' . $codigo . '\'
		GROUP BY T0.CANCELED
)VentasClientes) AS "CantidadDeClientes2020",
------------------------------------------AÑO 2021--------------------------------------------
(SELECT SUM(Vtas."Cantidad1")
				 FROM(
					SELECT T1."Quantity" "Cantidad1"
					FROM  HN_OPTRONICS.OQUT T0
					INNER JOIN HN_OPTRONICS.QUT1 T1 ON T0."DocEntry" = T1."DocEntry" 
					WHERE YEAR(T0."DocDate") = YEAR(NOW()) -2 AND T1."ItemCode" =  \'' . $codigo . '\'
				)Vtas
			)AS "Cot Pz21",
	
			(SELECT COUNT(DISTINCT(T2."DocNum")) 
					FROM  HN_OPTRONICS.OQUT T2 
					INNER JOIN HN_OPTRONICS.QUT1 T1 ON T2."DocEntry" = T1."DocEntry" WHERE YEAR(T2."DocDate") = YEAR(NOW()) -2
					AND T1."ItemCode" =  \'' . $codigo . '\'
			)AS "Cot Doc21",
				
	(SELECT SUM(Ventas."Cantidad1")
FROM(
	SELECT CASE WHEN T0.CANCELED = \'C\' THEN (T1."Quantity"*-1) ELSE (T1."Quantity") END AS "Cantidad1" 
				FROM HN_OPTRONICS.OINV T0
				INNER JOIN HN_OPTRONICS.INV1 T1 ON T0."DocEntry" = T1."DocEntry" 
				WHERE  YEAR(T0."DocDate") = YEAR(NOW()) -2 AND T1."ItemCode" =  \'' . $codigo . '\'
				
				UNION ALL 
				
	SELECT CASE WHEN T0.CANCELED = \'C\' THEN (T1."Quantity") ELSE (T1."Quantity" * -1) END AS "Cantidad1" 
				FROM HN_OPTRONICS.ORIN T0
				INNER JOIN HN_OPTRONICS.RIN1 T1 ON T0."DocEntry" = T1."DocEntry" 
				WHERE  T1."BaseType" <> \'203\'  AND YEAR(T0."DocDate") = YEAR(NOW()) -2 AND T1."ItemCode" =  \'' . $codigo . '\'
				)Ventas
				) AS "Ventas21",
	
	(SELECT COUNT(DISTINCT(Doc."Documento"))
	 		FROM
			(SELECT T2."DocNum" "Documento" 
				FROM HN_OPTRONICS.OINV T2 
				INNER JOIN HN_OPTRONICS.INV1 T1 ON T2."DocEntry" = T1."DocEntry" WHERE YEAR(T2."DocDate") = YEAR(NOW()) -2
				AND T1."ItemCode" =  \'' . $codigo . '\'
				
				UNION ALL
				
				SELECT T2."DocNum" "Documento"  
				FROM HN_OPTRONICS.ORIN T2 
				INNER JOIN HN_OPTRONICS.RIN1 T1 ON T2."DocEntry" = T1."DocEntry" WHERE  YEAR(T2."DocDate") = YEAR(NOW()) -2 AND  T1."BaseType" <> \'203\' 
				AND T1."ItemCode" =  \'' . $codigo . '\' 
		)Doc
		)AS "Fac Doc21",
		
	(SELECT SUM(VentasClientes."CantClientes")
 FROM (SELECT CASE WHEN T0.CANCELED = \'C\' THEN COUNT(DISTINCT(T0."CardName")) * -1 ELSE COUNT(DISTINCT(T0."CardName")) END AS "CantClientes"
		FROM HN_OPTRONICS.OINV T0 
		INNER JOIN HN_OPTRONICS.INV1 T1 ON T0."DocEntry" = T1."DocEntry" 
		INNER JOIN HN_OPTRONICS.OITM T3 ON T1."ItemCode" = T3."ItemCode" 
		INNER JOIN HN_OPTRONICS.OITB T4 ON T4."ItmsGrpCod" = T3."ItmsGrpCod" 
		INNER JOIN HN_OPTRONICS.OSLP T5 ON T0."SlpCode" = T5."SlpCode" 
		WHERE YEAR(T0."DocDate") = YEAR(NOW()) -2 AND T1."ItemCode" =  \'' . $codigo . '\'
		GROUP BY T0.CANCELED
UNION ALL  
	SELECT CASE WHEN T0.CANCELED = \'C\' THEN COUNT(DISTINCT(T0."CardName"))* -1  ELSE COUNT(DISTINCT(T0."CardName"))  END AS "CantClientes"
		FROM HN_OPTRONICS.ORIN T0 
		INNER JOIN HN_OPTRONICS.RIN1 T1 ON T0."DocEntry" = T1."DocEntry" 
		INNER JOIN HN_OPTRONICS.OITM T3 ON T1."ItemCode" = T3."ItemCode" 
		INNER JOIN HN_OPTRONICS.OITB T4 ON T4."ItmsGrpCod" = T3."ItmsGrpCod" 
		INNER JOIN HN_OPTRONICS.OSLP T5 ON T0."SlpCode" = T5."SlpCode" 
		WHERE YEAR(T0."DocDate") = YEAR(NOW()) -2 AND T1."BaseType" <> \'203\'  AND T1."ItemCode" =  \'' . $codigo . '\'
		GROUP BY T0.CANCELED
)VentasClientes) AS "CantidadDeClientes2021",
------------------------------------------AÑO 2022--------------------------------------------
(SELECT SUM(Vtas."Cantidad1")
				 FROM(
					SELECT T1."Quantity" "Cantidad1"
					FROM  HN_OPTRONICS.OQUT T0
					INNER JOIN HN_OPTRONICS.QUT1 T1 ON T0."DocEntry" = T1."DocEntry" 
					WHERE YEAR(T0."DocDate") = YEAR(NOW()) -1 AND T1."ItemCode" =  \'' . $codigo . '\'
				)Vtas
			)AS "Cot Pz22",
	
			(SELECT COUNT(DISTINCT(T2."DocNum")) 
					FROM  HN_OPTRONICS.OQUT T2 
					INNER JOIN HN_OPTRONICS.QUT1 T1 ON T2."DocEntry" = T1."DocEntry" WHERE YEAR(T2."DocDate") = YEAR(NOW()) -1
					AND T1."ItemCode" =  \'' . $codigo . '\'
			)AS "Cot Doc22",
				
	(SELECT SUM(Ventas."Cantidad1")
FROM(
	SELECT CASE WHEN T0.CANCELED = \'C\' THEN (T1."Quantity"*-1) ELSE (T1."Quantity") END AS "Cantidad1" 
				FROM HN_OPTRONICS.OINV T0
				INNER JOIN HN_OPTRONICS.INV1 T1 ON T0."DocEntry" = T1."DocEntry" 
				WHERE YEAR(T0."DocDate") = YEAR(NOW()) -1 AND T1."ItemCode" = \'' . $codigo . '\'
				
				UNION ALL 
				
	SELECT CASE WHEN T0.CANCELED = \'C\' THEN (T1."Quantity") ELSE (T1."Quantity" * -1) END AS "Cantidad1" 
				FROM HN_OPTRONICS.ORIN T0
				INNER JOIN HN_OPTRONICS.RIN1 T1 ON T0."DocEntry" = T1."DocEntry" 
				WHERE  T1."BaseType" <> \'203\'  AND YEAR(T0."DocDate") = YEAR(NOW()) -1 AND T1."ItemCode" =  \'' . $codigo . '\'
				)Ventas
				) AS "Ventas22",
	
	(SELECT COUNT(DISTINCT(Doc."Documento"))
	 		FROM
			(SELECT T2."DocNum" "Documento" 
				FROM HN_OPTRONICS.OINV T2 
				INNER JOIN HN_OPTRONICS.INV1 T1 ON T2."DocEntry" = T1."DocEntry" WHERE  YEAR(T2."DocDate") = YEAR(NOW()) -1
				AND T1."ItemCode" =  \'' . $codigo . '\'
				
				UNION ALL
				
				SELECT T2."DocNum" "Documento"  
				FROM HN_OPTRONICS.ORIN T2 
				INNER JOIN HN_OPTRONICS.RIN1 T1 ON T2."DocEntry" = T1."DocEntry" WHERE YEAR(T2."DocDate") = YEAR(NOW()) -1 AND  T1."BaseType" <> \'203\' 
				AND T1."ItemCode" =  \'' . $codigo . '\'
		)Doc
		)AS "Fac Doc22",
		
	(SELECT SUM(VentasClientes."CantClientes")
 FROM (SELECT CASE WHEN T0.CANCELED = \'C\' THEN COUNT(DISTINCT(T0."CardName")) * -1 ELSE COUNT(DISTINCT(T0."CardName")) END AS "CantClientes"
		FROM HN_OPTRONICS.OINV T0 
		INNER JOIN HN_OPTRONICS.INV1 T1 ON T0."DocEntry" = T1."DocEntry" 
		INNER JOIN HN_OPTRONICS.OITM T3 ON T1."ItemCode" = T3."ItemCode" 
		INNER JOIN HN_OPTRONICS.OITB T4 ON T4."ItmsGrpCod" = T3."ItmsGrpCod" 
		INNER JOIN HN_OPTRONICS.OSLP T5 ON T0."SlpCode" = T5."SlpCode" 
		WHERE YEAR(T0."DocDate") = YEAR(NOW()) -1 AND T1."ItemCode" =  \'' . $codigo . '\'
		GROUP BY T0.CANCELED
UNION ALL  
	SELECT CASE WHEN T0.CANCELED = \'C\' THEN COUNT(DISTINCT(T0."CardName"))* -1  ELSE COUNT(DISTINCT(T0."CardName"))  END AS "CantClientes"
		FROM HN_OPTRONICS.ORIN T0 
		INNER JOIN HN_OPTRONICS.RIN1 T1 ON T0."DocEntry" = T1."DocEntry" 
		INNER JOIN HN_OPTRONICS.OITM T3 ON T1."ItemCode" = T3."ItemCode" 
		INNER JOIN HN_OPTRONICS.OITB T4 ON T4."ItmsGrpCod" = T3."ItmsGrpCod" 
		INNER JOIN HN_OPTRONICS.OSLP T5 ON T0."SlpCode" = T5."SlpCode" 
		WHERE YEAR(T0."DocDate") = YEAR(NOW()) -1 AND T1."BaseType" <> \'203\'  AND T1."ItemCode" =  \'' . $codigo . '\'
		GROUP BY T0.CANCELED
)VentasClientes) AS "CantidadDeClientes2022",
------------------------------------------AÑO 2023--------------------------------------------
(SELECT SUM(Vtas."Cantidad1")
				 FROM(
					SELECT T1."Quantity" "Cantidad1"
					FROM  HN_OPTRONICS.OQUT T0
					INNER JOIN HN_OPTRONICS.QUT1 T1 ON T0."DocEntry" = T1."DocEntry" 
					WHERE  YEAR(T0."DocDate") = YEAR(NOW())  AND T1."ItemCode" =  \'' . $codigo . '\'
				)Vtas
			)AS "Cot Pz23",
	
			(SELECT COUNT(DISTINCT(T2."DocNum")) 
					FROM  HN_OPTRONICS.OQUT T2 
					INNER JOIN HN_OPTRONICS.QUT1 T1 ON T2."DocEntry" = T1."DocEntry" WHERE  YEAR(T2."DocDate") = YEAR(NOW()) 
					AND T1."ItemCode" =  \'' . $codigo . '\'
			)AS "Cot Doc23",
				
	(SELECT SUM(Ventas."Cantidad1")
FROM(
	SELECT CASE WHEN T0.CANCELED = \'C\' THEN (T1."Quantity"*-1) ELSE (T1."Quantity") END AS "Cantidad1" 
				FROM HN_OPTRONICS.OINV T0
				INNER JOIN HN_OPTRONICS.INV1 T1 ON T0."DocEntry" = T1."DocEntry" 
				WHERE YEAR(T0."DocDate") = YEAR(NOW())  AND T1."ItemCode" =  \'' . $codigo . '\'
				
				UNION ALL 
				
	SELECT CASE WHEN T0.CANCELED = \'C\' THEN (T1."Quantity") ELSE (T1."Quantity" * -1) END AS "Cantidad1" 
				FROM HN_OPTRONICS.ORIN T0
				INNER JOIN HN_OPTRONICS.RIN1 T1 ON T0."DocEntry" = T1."DocEntry" 
				WHERE  T1."BaseType" <> \'203\'  AND YEAR(T0."DocDate") = YEAR(NOW())  AND T1."ItemCode" =  \'' . $codigo . '\'
				)Ventas
				) AS "Ventas23",
	
	(SELECT COUNT(DISTINCT(Doc."Documento"))
	 		FROM
			(SELECT T2."DocNum" "Documento" 
				FROM HN_OPTRONICS.OINV T2 
				INNER JOIN HN_OPTRONICS.INV1 T1 ON T2."DocEntry" = T1."DocEntry" WHERE YEAR(T2."DocDate") = YEAR(NOW()) 
				AND T1."ItemCode" =  \'' . $codigo . '\'
				
				UNION ALL
				
				SELECT T2."DocNum" "Documento"  
				FROM HN_OPTRONICS.ORIN T2 
				INNER JOIN HN_OPTRONICS.RIN1 T1 ON T2."DocEntry" = T1."DocEntry" WHERE  YEAR(T2."DocDate") = YEAR(NOW())  AND  T1."BaseType" <> \'203\' 
				AND T1."ItemCode" =  \'' . $codigo . '\'
		)Doc
		)AS "Fac Doc23",
		
                (SELECT SUM(VentasClientes."CantClientes")
            FROM (SELECT CASE WHEN T0.CANCELED = \'C\' THEN COUNT(DISTINCT(T0."CardName")) * -1 ELSE COUNT(DISTINCT(T0."CardName")) END AS "CantClientes"
                    FROM HN_OPTRONICS.OINV T0 
                    INNER JOIN HN_OPTRONICS.INV1 T1 ON T0."DocEntry" = T1."DocEntry" 
                    INNER JOIN HN_OPTRONICS.OITM T3 ON T1."ItemCode" = T3."ItemCode" 
                    INNER JOIN HN_OPTRONICS.OITB T4 ON T4."ItmsGrpCod" = T3."ItmsGrpCod" 
                    INNER JOIN HN_OPTRONICS.OSLP T5 ON T0."SlpCode" = T5."SlpCode" 
                    WHERE YEAR(T0."DocDate") = YEAR(NOW())  AND T1."ItemCode" =  \'' . $codigo . '\'
                    GROUP BY T0.CANCELED
            UNION ALL  
                SELECT CASE WHEN T0.CANCELED = \'C\' THEN COUNT(DISTINCT(T0."CardName"))* -1  ELSE COUNT(DISTINCT(T0."CardName"))  END AS "CantClientes"
                    FROM HN_OPTRONICS.ORIN T0 
                    INNER JOIN HN_OPTRONICS.RIN1 T1 ON T0."DocEntry" = T1."DocEntry" 
                    INNER JOIN HN_OPTRONICS.OITM T3 ON T1."ItemCode" = T3."ItemCode" 
                    INNER JOIN HN_OPTRONICS.OITB T4 ON T4."ItmsGrpCod" = T3."ItmsGrpCod" 
                    INNER JOIN HN_OPTRONICS.OSLP T5 ON T0."SlpCode" = T5."SlpCode" 
                    WHERE YEAR(T0."DocDate") = YEAR(NOW())  AND T1."BaseType" <> \'203\'  AND T1."ItemCode" =  \'' . $codigo . '\'
                    GROUP BY T0.CANCELED
            )VentasClientes) AS "CantidadDeClientes2023"
            FROM HN_OPTRONICS.OQUT T2 
            INNER JOIN HN_OPTRONICS.QUT1 T10 ON T2."DocEntry" = T10."DocEntry" 
            WHERE  YEAR(T2."DocDate") >= YEAR(NOW()) -4
            GROUP BY T2."DocDate"
            )Vtas
            ');

        $consulta = odbc_exec($conn, $sql);
        return  ($consulta);
    }
    function PORCENTAJE_FIBREMEX()  /* VENTAS  */
    {
        $codigo = $_POST['Codigo'];




        $datasource = 'DRIVER=HDBODBC;SERVERNODE=192.168.2.19:30015;CHAR_AS_UTF8=1;';
        $username   = "USR_LECTURA";
        $password   = "SPL.Lectura202xx";

        $conn   = odbc_connect($datasource, $username, $password, SQL_CUR_USE_ODBC);
        $sql = ('
SELECT Vtas."Año" "Año", 
		CASE WHEN Vtas."Año" = YEAR(NOW()) -4 THEN Vtas."Cot Pz19" WHEN Vtas."Año" = YEAR(NOW()) -3 THEN Vtas."Cot Pz20" WHEN Vtas."Año" = YEAR(NOW()) -2 THEN Vtas."Cot Pz21" 
			 WHEN Vtas."Año" = YEAR(NOW()) -1 THEN Vtas."Cot Pz22" WHEN Vtas."Año" = YEAR(NOW()) THEN Vtas."Cot Pz23" END AS "Cot Pz",
		CASE WHEN Vtas."Año" = YEAR(NOW()) -4 THEN Vtas."Cot Doc19" WHEN Vtas."Año" = YEAR(NOW()) -3 THEN Vtas."Cot Doc20" WHEN Vtas."Año" = YEAR(NOW()) -2 THEN Vtas."Cot Doc21"
			 WHEN Vtas."Año" = YEAR(NOW()) -1 THEN Vtas."Cot Doc22" WHEN Vtas."Año" = YEAR(NOW()) THEN Vtas."Cot Doc23" END AS "Cot Doc",		
		CASE WHEN Vtas."Año" = YEAR(NOW()) -4 THEN Vtas."Ventas19" WHEN Vtas."Año" = YEAR(NOW()) -3 THEN Vtas."Ventas20" WHEN Vtas."Año" = YEAR(NOW()) -2 THEN Vtas."Ventas21"
			 WHEN Vtas."Año" = YEAR(NOW()) -1 THEN Vtas."Ventas22" WHEN Vtas."Año" = YEAR(NOW()) THEN Vtas."Ventas23" END AS "Ventas",			 
		CASE WHEN Vtas."Año" = YEAR(NOW()) -4 THEN Vtas."Fac Doc19" WHEN Vtas."Año" = YEAR(NOW()) -3 THEN Vtas."Fac Doc20" WHEN Vtas."Año" = YEAR(NOW()) -2 THEN Vtas."Fac Doc21"
			 WHEN Vtas."Año" = YEAR(NOW()) -1 THEN Vtas."Fac Doc22" WHEN Vtas."Año" = YEAR(NOW()) THEN Vtas."Fac Doc23" END AS "Fac Doc",			 
		CASE WHEN Vtas."Año" = YEAR(NOW()) -4 THEN Vtas."CantidadDeClientes2019" WHEN Vtas."Año" = YEAR(NOW()) -3 THEN Vtas."CantidadDeClientes2020" WHEN Vtas."Año" = YEAR(NOW()) -2 THEN Vtas."CantidadDeClientes2021" 
		 	 WHEN Vtas."Año" = YEAR(NOW()) -1 THEN Vtas."CantidadDeClientes2022" WHEN Vtas."Año" = YEAR(NOW()) THEN Vtas."CantidadDeClientes2023" END AS "Clientes",
		CASE WHEN Vtas."Año" = YEAR(NOW()) -4 THEN ROUND((Vtas."Ventas19" / Vtas."Cot Pz19")* 100,2)WHEN Vtas."Año" = YEAR(NOW()) -3 THEN ROUND((Vtas."Ventas20" / Vtas."Cot Pz20") * 100,2)
			 WHEN Vtas."Año" = YEAR(NOW()) -2 THEN ROUND((Vtas."Ventas21" / Vtas."Cot Pz21") * 100,2)WHEN Vtas."Año" = YEAR(NOW()) -1 THEN ROUND((Vtas."Ventas22" / Vtas."Cot Pz22") * 100,2)  
			 WHEN Vtas."Año" = YEAR(NOW()) THEN ROUND((Vtas."Ventas23" / Vtas."Cot Pz23") * 100,2) END AS "PorcentajeConversion"
FROM(
		SELECT DISTINCT YEAR(T2."DocDate") AS "Año",
				(SELECT SUM(Vtas."Cantidad1")
					 FROM(
						SELECT T1."Quantity" "Cantidad1"
						FROM HN_FIBREMEX.OQUT T0
						INNER JOIN HN_FIBREMEX.QUT1 T1 ON T0."DocEntry" = T1."DocEntry" 
						WHERE YEAR(T0."DocDate") = YEAR(NOW()) -4 AND T1."ItemCode" =\'' . $codigo . '\'
					)Vtas
				)AS "Cot Pz19",
		
		(SELECT COUNT(DISTINCT(T2."DocNum")) 
						FROM HN_FIBREMEX.OQUT T2 
						INNER JOIN HN_FIBREMEX.QUT1 T1 ON T2."DocEntry" = T1."DocEntry" WHERE YEAR(T2."DocDate") = YEAR(NOW()) -4 
						AND T1."ItemCode" =\'' . $codigo . '\'
				)AS "Cot Doc19",
				
		(SELECT SUM(Ventas."Cantidad1")
FROM(
		SELECT CASE WHEN T0.CANCELED = \'C\' THEN (T1."Quantity"*-1) ELSE (T1."Quantity") END AS "Cantidad1" 
					FROM HN_FIBREMEX.OINV T0
					INNER JOIN HN_FIBREMEX.INV1 T1 ON T0."DocEntry" = T1."DocEntry" 
					WHERE YEAR(T0."DocDate") = YEAR(NOW()) -4 AND T1."ItemCode" =\'' . $codigo . '\'
					
					UNION ALL 
					
		SELECT CASE WHEN T0.CANCELED = \'C\' THEN (T1."Quantity") ELSE (T1."Quantity" * -1) END AS "Cantidad1" 
					FROM HN_FIBREMEX.ORIN T0
					INNER JOIN HN_FIBREMEX.RIN1 T1 ON T0."DocEntry" = T1."DocEntry" 
					WHERE T1."BaseType" <> \'203\' AND YEAR(T0."DocDate") = YEAR(NOW()) -4 AND T1."ItemCode" =\'' . $codigo . '\'
					)Ventas
					) AS "Ventas19",
		(SELECT COUNT(DISTINCT(Doc."Documento"))
					FROM
					(SELECT T2."DocNum" "Documento" 
						FROM HN_FIBREMEX.OINV T2 
						INNER JOIN HN_FIBREMEX.INV1 T1 ON T2."DocEntry" = T1."DocEntry" WHERE YEAR(T2."DocDate") = YEAR(NOW()) -4 
						AND T1."ItemCode" =\'' . $codigo . '\' 
						
						UNION ALL
						
						SELECT T2."DocNum" "Documento"  
						FROM HN_FIBREMEX.ORIN T2 
						INNER JOIN HN_FIBREMEX.RIN1 T1 ON T2."DocEntry" = T1."DocEntry" WHERE YEAR(T2."DocDate") = YEAR(NOW()) -4 AND  T1."BaseType" <> \'203\' 
						AND T1."ItemCode" =\'' . $codigo . '\'
				)Doc
				)AS "Fac Doc19",
					
		(SELECT SUM(VentasClientes."CantClientes")
 FROM(
	 	 SELECT CASE WHEN T0.CANCELED = \'C\' THEN COUNT(DISTINCT(T0."CardName")) * -1 ELSE COUNT(DISTINCT(T0."CardName")) END AS "CantClientes"
			FROM HN_FIBREMEX.OINV T0 
			INNER JOIN HN_FIBREMEX.INV1 T1 ON T0."DocEntry" = T1."DocEntry" 
			INNER JOIN HN_FIBREMEX.OITM T3 ON T1."ItemCode" = T3."ItemCode" 
			INNER JOIN HN_FIBREMEX.OITB T4 ON T4."ItmsGrpCod" = T3."ItmsGrpCod" 
			INNER JOIN HN_FIBREMEX.OSLP T5 ON T0."SlpCode" = T5."SlpCode" 
			WHERE YEAR(T0."DocDate") = YEAR(NOW()) -4 AND T1."ItemCode" =\'' . $codigo . '\'
			GROUP BY T0.CANCELED
UNION ALL  
		 SELECT CASE WHEN T0.CANCELED = \'C\' THEN COUNT(DISTINCT(T0."CardName"))* -1  ELSE COUNT(DISTINCT(T0."CardName"))  END AS "CantClientes"
			FROM HN_FIBREMEX.ORIN T0 
			INNER JOIN HN_FIBREMEX.RIN1 T1 ON T0."DocEntry" = T1."DocEntry" 
			INNER JOIN HN_FIBREMEX.OITM T3 ON T1."ItemCode" = T3."ItemCode" 
			INNER JOIN HN_FIBREMEX.OITB T4 ON T4."ItmsGrpCod" = T3."ItmsGrpCod" 
			INNER JOIN HN_FIBREMEX.OSLP T5 ON T0."SlpCode" = T5."SlpCode" 
			WHERE YEAR(T0."DocDate") = YEAR(NOW()) -4 AND T1."BaseType" <> \'203\'  AND T1."ItemCode" =\'' . $codigo . '\'
			GROUP BY T0.CANCELED
)VentasClientes) AS "CantidadDeClientes2019",

------------------------------------------AÑO 2020--------------------------------------------
	(SELECT SUM(Vtas."Cantidad1")
				 FROM(
					SELECT T1."Quantity" "Cantidad1"
					FROM HN_FIBREMEX.OQUT T0
					INNER JOIN HN_FIBREMEX.QUT1 T1 ON T0."DocEntry" = T1."DocEntry" 
					WHERE YEAR(T0."DocDate") = YEAR(NOW()) -3 AND T1."ItemCode" =\'' . $codigo . '\'
				)Vtas
			)AS "Cot Pz20",
	
			(SELECT COUNT(DISTINCT(T2."DocNum")) 
					FROM HN_FIBREMEX.OQUT T2 
					INNER JOIN HN_FIBREMEX.QUT1 T1 ON T2."DocEntry" = T1."DocEntry" WHERE YEAR(T2."DocDate") = YEAR(NOW()) -3 
					AND T1."ItemCode" =\'' . $codigo . '\'
			)AS "Cot Doc20",
				
	(SELECT SUM(Ventas."Cantidad1")
FROM(
	SELECT CASE WHEN T0.CANCELED = \'C\' THEN (T1."Quantity"*-1) ELSE (T1."Quantity") END AS "Cantidad1" 
				FROM HN_FIBREMEX.OINV T0
				INNER JOIN HN_FIBREMEX.INV1 T1 ON T0."DocEntry" = T1."DocEntry" 
				WHERE YEAR(T0."DocDate") = YEAR(NOW()) -3 AND T1."ItemCode" =\'' . $codigo . '\'
				
				UNION ALL 
				
	SELECT CASE WHEN T0.CANCELED = \'C\' THEN (T1."Quantity") ELSE (T1."Quantity" * -1) END AS "Cantidad1" 
				FROM HN_FIBREMEX.ORIN T0
				INNER JOIN HN_FIBREMEX.RIN1 T1 ON T0."DocEntry" = T1."DocEntry" 
				WHERE  T1."BaseType" <> \'203\'  AND YEAR(T0."DocDate") = YEAR(NOW()) -3 AND T1."ItemCode" =\'' . $codigo . '\'
				)Ventas
				) AS "Ventas20",
	
	(SELECT COUNT(DISTINCT(Doc."Documento"))
	 		FROM
			(SELECT T2."DocNum" "Documento" 
				FROM HN_FIBREMEX.OINV T2 
				INNER JOIN HN_FIBREMEX.INV1 T1 ON T2."DocEntry" = T1."DocEntry" WHERE YEAR(T2."DocDate") = YEAR(NOW()) -3 
				AND T1."ItemCode" =\'' . $codigo . '\'
				
				UNION ALL
				
				SELECT T2."DocNum" "Documento"  
				FROM HN_FIBREMEX.ORIN T2 
				INNER JOIN HN_FIBREMEX.RIN1 T1 ON T2."DocEntry" = T1."DocEntry" WHERE YEAR(T2."DocDate") = YEAR(NOW()) -3 AND  T1."BaseType" <> \'203\' 
				AND T1."ItemCode" = \'' . $codigo . '\'
		)Doc
		)AS "Fac Doc20",
		
	(SELECT SUM(VentasClientes."CantClientes")
 FROM (SELECT CASE WHEN T0.CANCELED = \'C\' THEN COUNT(DISTINCT(T0."CardName")) * -1 ELSE COUNT(DISTINCT(T0."CardName")) END AS "CantClientes"
		FROM HN_FIBREMEX.OINV T0 
		INNER JOIN HN_FIBREMEX.INV1 T1 ON T0."DocEntry" = T1."DocEntry" 
		INNER JOIN HN_FIBREMEX.OITM T3 ON T1."ItemCode" = T3."ItemCode" 
		INNER JOIN HN_FIBREMEX.OITB T4 ON T4."ItmsGrpCod" = T3."ItmsGrpCod" 
		INNER JOIN HN_FIBREMEX.OSLP T5 ON T0."SlpCode" = T5."SlpCode" 
		WHERE YEAR(T0."DocDate") = YEAR(NOW()) -3 AND T1."ItemCode" =\'' . $codigo . '\'
		GROUP BY T0.CANCELED
UNION ALL  
	SELECT CASE WHEN T0.CANCELED = \'C\' THEN COUNT(DISTINCT(T0."CardName"))* -1  ELSE COUNT(DISTINCT(T0."CardName"))  END AS "CantClientes"
		FROM HN_FIBREMEX.ORIN T0 
		INNER JOIN HN_FIBREMEX.RIN1 T1 ON T0."DocEntry" = T1."DocEntry" 
		INNER JOIN HN_FIBREMEX.OITM T3 ON T1."ItemCode" = T3."ItemCode" 
		INNER JOIN HN_FIBREMEX.OITB T4 ON T4."ItmsGrpCod" = T3."ItmsGrpCod" 
		INNER JOIN HN_FIBREMEX.OSLP T5 ON T0."SlpCode" = T5."SlpCode" 
		WHERE YEAR(T0."DocDate") = YEAR(NOW()) -3 AND T1."BaseType" <> \'203\'  AND T1."ItemCode" = \'' . $codigo . '\'
		GROUP BY T0.CANCELED
)VentasClientes) AS "CantidadDeClientes2020",
------------------------------------------AÑO 2021--------------------------------------------
(SELECT SUM(Vtas."Cantidad1")
				 FROM(
					SELECT T1."Quantity" "Cantidad1"
					FROM HN_FIBREMEX.OQUT T0
					INNER JOIN HN_FIBREMEX.QUT1 T1 ON T0."DocEntry" = T1."DocEntry" 
					WHERE YEAR(T0."DocDate") = YEAR(NOW()) -2 AND T1."ItemCode" = \'' . $codigo . '\'
				)Vtas
			)AS "Cot Pz21",
	
			(SELECT COUNT(DISTINCT(T2."DocNum")) 
					FROM HN_FIBREMEX.OQUT T2 
					INNER JOIN HN_FIBREMEX.QUT1 T1 ON T2."DocEntry" = T1."DocEntry" WHERE YEAR(T2."DocDate") = YEAR(NOW()) -2 
					AND T1."ItemCode" = \'' . $codigo . '\'
			)AS "Cot Doc21",
				
	(SELECT SUM(Ventas."Cantidad1")
FROM(
	SELECT CASE WHEN T0.CANCELED = \'C\' THEN (T1."Quantity"*-1) ELSE (T1."Quantity") END AS "Cantidad1" 
				FROM HN_FIBREMEX.OINV T0
				INNER JOIN HN_FIBREMEX.INV1 T1 ON T0."DocEntry" = T1."DocEntry" 
				WHERE YEAR(T0."DocDate") = YEAR(NOW()) -2 AND T1."ItemCode" = \'' . $codigo . '\'
				
				UNION ALL 
				
	SELECT CASE WHEN T0.CANCELED = \'C\' THEN (T1."Quantity") ELSE (T1."Quantity" * -1) END AS "Cantidad1" 
				FROM HN_FIBREMEX.ORIN T0
				INNER JOIN HN_FIBREMEX.RIN1 T1 ON T0."DocEntry" = T1."DocEntry" 
				WHERE  T1."BaseType" <> \'203\'  AND YEAR(T0."DocDate") = YEAR(NOW()) -2 AND T1."ItemCode" = \'' . $codigo . '\'
				)Ventas
				) AS "Ventas21",
	
	(SELECT COUNT(DISTINCT(Doc."Documento"))
	 		FROM
			(SELECT T2."DocNum" "Documento" 
				FROM HN_FIBREMEX.OINV T2 
				INNER JOIN HN_FIBREMEX.INV1 T1 ON T2."DocEntry" = T1."DocEntry" WHERE YEAR(T2."DocDate") = YEAR(NOW()) -2 
				AND T1."ItemCode" = \'' . $codigo . '\'
				
				UNION ALL
				
				SELECT T2."DocNum" "Documento"  
				FROM HN_FIBREMEX.ORIN T2 
				INNER JOIN HN_FIBREMEX.RIN1 T1 ON T2."DocEntry" = T1."DocEntry" WHERE YEAR(T2."DocDate") = YEAR(NOW()) -2 AND  T1."BaseType" <> \'203\' 
				AND T1."ItemCode" = \'' . $codigo . '\' 
		)Doc
		)AS "Fac Doc21",
		
	(SELECT SUM(VentasClientes."CantClientes")
 FROM (SELECT CASE WHEN T0.CANCELED = \'C\' THEN COUNT(DISTINCT(T0."CardName")) * -1 ELSE COUNT(DISTINCT(T0."CardName")) END AS "CantClientes"
		FROM HN_FIBREMEX.OINV T0 
		INNER JOIN HN_FIBREMEX.INV1 T1 ON T0."DocEntry" = T1."DocEntry" 
		INNER JOIN HN_FIBREMEX.OITM T3 ON T1."ItemCode" = T3."ItemCode" 
		INNER JOIN HN_FIBREMEX.OITB T4 ON T4."ItmsGrpCod" = T3."ItmsGrpCod" 
		INNER JOIN HN_FIBREMEX.OSLP T5 ON T0."SlpCode" = T5."SlpCode" 
		WHERE YEAR(T0."DocDate") = YEAR(NOW()) -2 AND T1."ItemCode" = \'' . $codigo . '\'
		GROUP BY T0.CANCELED
UNION ALL  
	SELECT CASE WHEN T0.CANCELED = \'C\' THEN COUNT(DISTINCT(T0."CardName"))* -1 ELSE COUNT(DISTINCT(T0."CardName"))  END AS "CantClientes"
		FROM HN_FIBREMEX.ORIN T0 
		INNER JOIN HN_FIBREMEX.RIN1 T1 ON T0."DocEntry" = T1."DocEntry" 
		INNER JOIN HN_FIBREMEX.OITM T3 ON T1."ItemCode" = T3."ItemCode" 
		INNER JOIN HN_FIBREMEX.OITB T4 ON T4."ItmsGrpCod" = T3."ItmsGrpCod" 
		INNER JOIN HN_FIBREMEX.OSLP T5 ON T0."SlpCode" = T5."SlpCode" 
		WHERE YEAR(T0."DocDate") = YEAR(NOW()) -2 AND T1."BaseType" <> \'203\' AND T1."ItemCode" = \'' . $codigo . '\'
		GROUP BY T0.CANCELED
)VentasClientes) AS "CantidadDeClientes2021",
------------------------------------------AÑO 2022--------------------------------------------
(SELECT SUM(Vtas."Cantidad1")
				 FROM(
					SELECT T1."Quantity" "Cantidad1"
					FROM HN_FIBREMEX.OQUT T0
					INNER JOIN HN_FIBREMEX.QUT1 T1 ON T0."DocEntry" = T1."DocEntry" 
					WHERE YEAR(T0."DocDate") = YEAR(NOW()) -1 AND T1."ItemCode" = \'' . $codigo . '\'
				)Vtas
			)AS "Cot Pz22",
	
			(SELECT COUNT(DISTINCT(T2."DocNum")) 
					FROM HN_FIBREMEX.OQUT T2 
					INNER JOIN HN_FIBREMEX.QUT1 T1 ON T2."DocEntry" = T1."DocEntry" WHERE YEAR(T2."DocDate") = YEAR(NOW()) -1 
					AND T1."ItemCode" = \'' . $codigo . '\'
			)AS "Cot Doc22",
				
	(SELECT SUM(Ventas."Cantidad1")
FROM(
	SELECT CASE WHEN T0.CANCELED = \'C\' THEN (T1."Quantity"*-1) ELSE (T1."Quantity") END AS "Cantidad1" 
				FROM HN_FIBREMEX.OINV T0
				INNER JOIN HN_FIBREMEX.INV1 T1 ON T0."DocEntry" = T1."DocEntry" 
				WHERE YEAR(T0."DocDate") = YEAR(NOW()) -1 AND T1."ItemCode" =\'' . $codigo . '\'
				
				UNION ALL 
				
	SELECT CASE WHEN T0.CANCELED = \'C\' THEN (T1."Quantity") ELSE (T1."Quantity" * -1) END AS "Cantidad1" 
				FROM HN_FIBREMEX.ORIN T0
				INNER JOIN HN_FIBREMEX.RIN1 T1 ON T0."DocEntry" = T1."DocEntry" 
				WHERE  T1."BaseType" <> \'203\'  AND YEAR(T0."DocDate") = YEAR(NOW()) -1 AND T1."ItemCode" = \'' . $codigo . '\'
				)Ventas
				) AS "Ventas22",
	
	(SELECT COUNT(DISTINCT(Doc."Documento"))
	 		FROM
			(SELECT T2."DocNum" "Documento" 
				FROM HN_FIBREMEX.OINV T2 
				INNER JOIN HN_FIBREMEX.INV1 T1 ON T2."DocEntry" = T1."DocEntry" WHERE YEAR(T2."DocDate") = YEAR(NOW()) -1 
				AND T1."ItemCode" = \'' . $codigo . '\'
				
				UNION ALL
				
				SELECT T2."DocNum" "Documento"  
				FROM HN_FIBREMEX.ORIN T2 
				INNER JOIN HN_FIBREMEX.RIN1 T1 ON T2."DocEntry" = T1."DocEntry" WHERE YEAR(T2."DocDate") = YEAR(NOW()) -1 AND  T1."BaseType" <> \'203\' 
				AND T1."ItemCode" = \'' . $codigo . '\'
		)Doc
		)AS "Fac Doc22",
		
	(SELECT SUM(VentasClientes."CantClientes")
 FROM (SELECT CASE WHEN T0.CANCELED = \'C\' THEN COUNT(DISTINCT(T0."CardName")) * -1 ELSE COUNT(DISTINCT(T0."CardName")) END AS "CantClientes"
		FROM HN_FIBREMEX.OINV T0 
		INNER JOIN HN_FIBREMEX.INV1 T1 ON T0."DocEntry" = T1."DocEntry" 
		INNER JOIN HN_FIBREMEX.OITM T3 ON T1."ItemCode" = T3."ItemCode" 
		INNER JOIN HN_FIBREMEX.OITB T4 ON T4."ItmsGrpCod" = T3."ItmsGrpCod" 
		INNER JOIN HN_FIBREMEX.OSLP T5 ON T0."SlpCode" = T5."SlpCode" 
		WHERE YEAR(T0."DocDate") = YEAR(NOW()) -1 AND T1."ItemCode" = \'' . $codigo . '\'
		GROUP BY T0.CANCELED
UNION ALL  
	SELECT CASE WHEN T0.CANCELED = \'C\' THEN COUNT(DISTINCT(T0."CardName"))* -1  ELSE COUNT(DISTINCT(T0."CardName"))  END AS "CantClientes"
		FROM HN_FIBREMEX.ORIN T0 
		INNER JOIN HN_FIBREMEX.RIN1 T1 ON T0."DocEntry" = T1."DocEntry" 
		INNER JOIN HN_FIBREMEX.OITM T3 ON T1."ItemCode" = T3."ItemCode" 
		INNER JOIN HN_FIBREMEX.OITB T4 ON T4."ItmsGrpCod" = T3."ItmsGrpCod" 
		INNER JOIN HN_FIBREMEX.OSLP T5 ON T0."SlpCode" = T5."SlpCode" 
		WHERE YEAR(T0."DocDate") = YEAR(NOW()) -1 AND T1."BaseType" <> \'203\'  AND T1."ItemCode" = \'' . $codigo . '\'
		GROUP BY T0.CANCELED
)VentasClientes) AS "CantidadDeClientes2022",
------------------------------------------AÑO 2023--------------------------------------------
(SELECT SUM(Vtas."Cantidad1")
				 FROM(
					SELECT T1."Quantity" "Cantidad1"
					FROM HN_FIBREMEX.OQUT T0
					INNER JOIN HN_FIBREMEX.QUT1 T1 ON T0."DocEntry" = T1."DocEntry" 
					WHERE YEAR(T0."DocDate") = YEAR(NOW()) AND T1."ItemCode" = \'' . $codigo . '\'
				)Vtas
			)AS "Cot Pz23",
	
			(SELECT COUNT(DISTINCT(T2."DocNum")) 
					FROM HN_FIBREMEX.OQUT T2 
					INNER JOIN HN_FIBREMEX.QUT1 T1 ON T2."DocEntry" = T1."DocEntry" WHERE YEAR(T2."DocDate") = YEAR(NOW()) 
					AND T1."ItemCode" = \'' . $codigo . '\'
			)AS "Cot Doc23",
				
	(SELECT SUM(Ventas."Cantidad1")
FROM(
	SELECT CASE WHEN T0.CANCELED = \'C\' THEN (T1."Quantity"*-1) ELSE (T1."Quantity") END AS "Cantidad1" 
				FROM HN_FIBREMEX.OINV T0
				INNER JOIN HN_FIBREMEX.INV1 T1 ON T0."DocEntry" = T1."DocEntry" 
				WHERE YEAR(T0."DocDate") = YEAR(NOW()) AND T1."ItemCode" = \'' . $codigo . '\'
				
				UNION ALL 
				
	SELECT CASE WHEN T0.CANCELED = \'C\' THEN (T1."Quantity") ELSE (T1."Quantity" * -1) END AS "Cantidad1" 
				FROM HN_FIBREMEX.ORIN T0
				INNER JOIN HN_FIBREMEX.RIN1 T1 ON T0."DocEntry" = T1."DocEntry" 
				WHERE T1."BaseType" <> \'203\'  AND YEAR(T0."DocDate") = YEAR(NOW()) AND T1."ItemCode" = \'' . $codigo . '\'
				)Ventas
				) AS "Ventas23",
	
	(SELECT COUNT(DISTINCT(Doc."Documento"))
	 		FROM
			(SELECT T2."DocNum" "Documento" 
				FROM HN_FIBREMEX.OINV T2 
				INNER JOIN HN_FIBREMEX.INV1 T1 ON T2."DocEntry" = T1."DocEntry" WHERE YEAR(T2."DocDate") = YEAR(NOW())
				AND T1."ItemCode" = \'' . $codigo . '\'
				
				UNION ALL
				
				SELECT T2."DocNum" "Documento"  
				FROM HN_FIBREMEX.ORIN T2 
				INNER JOIN HN_FIBREMEX.RIN1 T1 ON T2."DocEntry" = T1."DocEntry" WHERE YEAR(T2."DocDate") = YEAR(NOW()) AND  T1."BaseType" <> \'203\' 
				AND T1."ItemCode" = \'' . $codigo . '\'
		)Doc
		)AS "Fac Doc23",
		
	(SELECT SUM(VentasClientes."CantClientes")
 FROM (SELECT CASE WHEN T0.CANCELED = \'C\' THEN COUNT(DISTINCT(T0."CardName")) * -1 ELSE COUNT(DISTINCT(T0."CardName")) END AS "CantClientes"
		FROM HN_FIBREMEX.OINV T0 
		INNER JOIN HN_FIBREMEX.INV1 T1 ON T0."DocEntry" = T1."DocEntry" 
		INNER JOIN HN_FIBREMEX.OITM T3 ON T1."ItemCode" = T3."ItemCode" 
		INNER JOIN HN_FIBREMEX.OITB T4 ON T4."ItmsGrpCod" = T3."ItmsGrpCod" 
		INNER JOIN HN_FIBREMEX.OSLP T5 ON T0."SlpCode" = T5."SlpCode" 
		WHERE YEAR(T0."DocDate") = YEAR(NOW()) AND T1."ItemCode" = \'' . $codigo . '\'
		GROUP BY T0.CANCELED
UNION ALL  
	SELECT CASE WHEN T0.CANCELED = \'C\' THEN COUNT(DISTINCT(T0."CardName"))* -1  ELSE COUNT(DISTINCT(T0."CardName"))  END AS "CantClientes"
		FROM HN_FIBREMEX.ORIN T0 
		INNER JOIN HN_FIBREMEX.RIN1 T1 ON T0."DocEntry" = T1."DocEntry" 
		INNER JOIN HN_FIBREMEX.OITM T3 ON T1."ItemCode" = T3."ItemCode" 
		INNER JOIN HN_FIBREMEX.OITB T4 ON T4."ItmsGrpCod" = T3."ItmsGrpCod" 
		INNER JOIN HN_FIBREMEX.OSLP T5 ON T0."SlpCode" = T5."SlpCode" 
		WHERE YEAR(T0."DocDate") = YEAR(NOW()) AND T1."BaseType" <> \'203\'  AND T1."ItemCode" = \'' . $codigo . '\'
		GROUP BY T0.CANCELED
)VentasClientes) AS "CantidadDeClientes2023"
FROM HN_FIBREMEX.OQUT T2 
INNER JOIN HN_FIBREMEX.QUT1 T10 ON T2."DocEntry" = T10."DocEntry" 
WHERE  YEAR(T2."DocDate") >= YEAR(NOW()) -4
GROUP BY T2."DocDate"
)Vtas
');
        /*   print_r($sql);
        exit; */
        $consulta = odbc_exec($conn, $sql);
        return  ($consulta);
    }
}
