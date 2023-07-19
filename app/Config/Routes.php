<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * RUTAS EN LA URL RMN
 * --------------------------------------------------------------------
 */
/* RUTA PARA DATATABLES DESDE EL CONTROLADOR */

$routes->get('/select_serverside', 'Home::select_serverside');

/*  */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('/inicio', 'Home::inicio');
$routes->get('/salir', 'Home::salir');
/* envio del formulario por post en login */
$routes->post('/login', 'Home::login');

/* USUARIOS RUTAS */
$routes->get('/usuarios', 'Home::usuarios');
$routes->get('/usercrear', 'Home::usercrear');
$routes->post('/registrar', 'Home::registrar');
$routes->post('/useractualizar', 'Home::useractualizar');
$routes->post('/actualizar', 'Home::actualizar');
$routes->get('/perfil', 'Home::perfil');
$routes->post('/actualizarperfil', 'Home::actualizarperfil');
/* 🆁🅼🅽 */
$routes->post('/userpermisos', 'Home::userpermisos');
$routes->post('/addpermiso', 'Home::addpermiso');
$routes->post('/permisos', 'Home::permisos');
$routes->post('/insertapermisos', 'Home::insertapermisos');

$routes->get('/listamodulos', 'Home::listamodulos');
$routes->get('/modulocrear', 'Home::modulocrear');
$routes->post('/registrarmodulo', 'Home::registrarmodulo');
$routes->get('/moduloedit/(:any)', 'Home::moduloedit/$1');
$routes->get('/modulodelete/(:any)', 'Home::modulodelete/$1');

$routes->post('/dataeditarmodulo', 'Home::dataeditarmodulo');


/* 🆁🅼🅽 */

$routes->get('/obteneruser/(:any)', 'Home::obteneruser/$1');
$routes->get('/usereliminar/(:any)', 'Home::usereliminar/$1');

/* FIN RUTAS USUARIOS */

/* RUTAS CLIENTES */
$routes->get('/clientes', 'Asas::clientes');
$routes->get('/busqueda', 'Asas::busqueda');
$routes->post('/B', 'Asas::B');
$routes->post('/docdetalle', 'Asas::docdetalle');

/* FIN RUTAS CLIENTES */

/* RUTAS DOCUMENTOS */
$routes->get('/documentos', 'DocNum::documentos');
$routes->get('/busqueda', 'DocNum::busqueda');
$routes->post('/Buscar', 'DocNum::Buscar');
$routes->post('/stockdisponible', 'DocNum::stockdisponible');
$routes->post('/transitoproduccion', 'DocNum::transitoproduccion');
$routes->post('/factorimportacion', 'DocNum::factorimportacion');
$routes->post('/detalleprecio', 'DocNum::detalleprecio');
$routes->get('/GenerarPDF', 'DocNum::GenerarPDF');
$routes->get('/ViewPDF', 'DocNum::ViewPDF');

$routes->get('/TablaComparativa', 'DocNum::TablaComparativa');
$routes->post('/preciocompetencia', 'DocNum::preciocompetencia');
$routes->post('/competencia', 'DocNum::competencia');
$routes->post('/registrarcompetencia', 'DocNum::registrarcompetencia');
$routes->post('/actualizarcompetencia', 'DocNum::actualizarcompetencia');

/* FIN RUTAS DOCUMENTOS */

/* RUTAS PROYECTOS */
$routes->get('/proyectos', 'Proyect::proyectos');
$routes->get('/busqueda', 'Proyect::busqueda');
$routes->post('/Buscar', 'Proyect::Buscar');
$routes->post('/stockdisponible', 'Proyect::stockdisponible');
$routes->post('/transitoproduccion', 'Proyect::transitoproduccion');
$routes->post('/factorimportacion', 'Proyect::factorimportacion');
$routes->post('/detalleprecio', 'Proyect::detalleprecio');
$routes->get('/GenerarPDF', 'Proyect::GenerarPDF');
$routes->get('/ViewPDF', 'Proyect::ViewPDF');

$routes->get('/TablaComparativa', 'Proyect::TablaComparativa');
$routes->post('/cedis', 'Proyect::cedis');

/* FIN RUTAS PROYECTOS */

/* RUTAS Investigacion de mercado */
$routes->get('/invmercados', 'InvMerc::invmercados');
$routes->get('/ivbusqueda', 'InvMerc::ivbusqueda');
$routes->post('/ivBuscar', 'InvMerc::ivBuscar');

$routes->post('/ivprecioscompetencia', 'InvMerc::ivprecioscompetencia');
$routes->post('/ivcompetencia', 'InvMerc::ivcompetencia');
$routes->post('/ivregistrarcompetencia', 'InvMerc::ivregistrarcompetencia');
$routes->post('/ivactualizarcompetencia', 'InvMerc::ivactualizarcompetencia');

/* FIN RUTAS Investigacion de mercado */

/* RUTAS CCOMPRAS*/
$routes->get('/compras', 'Compra::compras');
$routes->get('/busqueda', 'Compra::busqueda');
$routes->post('/Buscar', 'Compra::Buscar');

$routes->post('/preciosproveedor', 'Compra::preciosproveedor');
$routes->post('/proveedor', 'Compra::proveedor');
$routes->post('/registrarproveedor', 'Compra::registrarproveedor');
$routes->post('/actualizarproveedor', 'Compra::actualizarproveedor');

/* FIN RUTAS CCOMPRAS*/

/* RUTAS LOGISTICA*/
$routes->get('/logistica', 'Logi::logistica');
$routes->get('/busqueda', 'Logi::busqueda');
$routes->post('/BuscarItem', 'Logi::BuscarItem');

$routes->get('/ficrear', 'Logi::ficrear');
$routes->post('/firegistrar', 'Logi::firegistrar');

$routes->post('/preciosproveedor', 'Logi::preciosproveedor');
$routes->post('/proveedor', 'Logi::proveedor');
$routes->post('/firegistrar', 'Logi::firegistrar');
$routes->post('/updateficables', 'Logi::updateficables');
$routes->post('/notificar', 'Logi::notificar');

/* FIN RUTAS LOGISTICA*/

/* RUTAS FAMILIAS */
$routes->get('/familias', 'Familia::familias');
$routes->post('/detalleFamiliaOptronics', 'Familia::detalleFamiliaOptronics');
$routes->post('/detalleFamiliaFibremex', 'Familia::detalleFamiliaFibremex');
$routes->post('/detalleFamiliaSplittel', 'Familia::detalleFamiliaSplittel');

$routes->post('/FamiliaSplittel', 'Familia::FamiliaSplittel');

$routes->post('/FamiliaFibremex', 'Familia::FamiliaFibremex');
$routes->post('/FamiliaOptronics', 'Familia::FamiliaOptronics');


$routes->post('/FamiliaFibremex80', 'Familia::FamiliaFibremex80');
$routes->post('/FamiliaFibremex15', 'Familia::FamiliaFibremex15');
$routes->post('/FamiliaFibremex5', 'Familia::FamiliaFibremex5');

$routes->post('/FamiliaOptronics80', 'Familia::FamiliaOptronics80');
$routes->post('/FamiliaOptronics15', 'Familia::FamiliaOptronics15');
$routes->post('/FamiliaOptronics5', 'Familia::FamiliaOptronics5');



$routes->post('/TablaFibremex80', 'Familia::TablaFibremex80');
$routes->post('/TablaFibremex15', 'Familia::TablaFibremex15');
$routes->post('/TablaFibremex5', 'Familia::TablaFibremex5');

$routes->post('/TablaOptro80', 'Familia::TablaOptro80');
$routes->post('/TablaOptro15', 'Familia::TablaOptro15');
$routes->post('/TablaOptro5', 'Familia::TablaOptro5');

$routes->post('/TablaSplittel80', 'Familia::TablaSplittel80');
$routes->post('/TablaSplittel15', 'Familia::TablaSplittel15');
$routes->post('/TablaSplittel5', 'Familia::TablaSplittel5');
/* FIN RUTAS FAMILIAS */

/* RUTAS KPIS */
$routes->get('/Kpis', 'Familia::Kpis');

$routes->post('/kpis_indicadores_ajax', 'Familia::kpis_indicadores_ajax');

/* FIN RUTAS KPIS */

/* RUTAS MONEX */
$routes->get('/depositos', 'Monex::depositos');
$routes->get('/cuentas', 'Monex::cuentas');
$routes->get('/PagosFibremex', 'Monex::PagosFibremex');
$routes->get('/PagosOptronics', 'Monex::PagosOptronics');

$routes->post('/TokenEmail', 'Monex::TokenEmail');
$routes->post('/pagosfibreadd', 'Monex::pagosfibreadd');
$routes->post('/pagofibreadata', 'Monex::pagosfibreadata');
$routes->post('/pagosoptroadd', 'Monex::pagosoptroadd');
$routes->post('/pagooptroadata', 'Monex::pagooptroadata');

/* FIN RUTAS MONEX */

/* RUTAS DASHBOARD */

$routes->get('/dashboard', 'Familia::dashboard');
$routes->get('/Planeacion', 'Familia::Planeacion');
$routes->get('/vista2', 'Familia::vista2');



$routes->get('/EmailPlaneacion', 'Familia::EmailPlaneacion');
$routes->get('/EmailPlaneacionTarea', 'Familia::EmailPlaneacionTarea');
$routes->post('/SendEmailPlaneacion', 'Familia::SendEmailPlaneacion');
$routes->post('/SendEmailPlaneacionTarea', 'Familia::SendEmailPlaneacionTarea');
$routes->post('/PlaneacionF', 'Familia::PlaneacionF');
$routes->post('/PlaneacionV2', 'Familia::PlaneacionV2');
$routes->post('/Planeacion/detalleAcumuladoVentas', 'Familia::detalleAcumuladoVentas');

/* RUTAS Blog */
$routes->get('/blog', 'Blog::blog');
$routes->get('/crearblog', 'Blog::crearblog');
$routes->post('/registrarblog', 'Blog::registrarblog');

$routes->get('/obtenerblog/(:any)', 'Blog::obtenerblog/$1');
$routes->get('/blogeliminar/(:any)', 'Blog::blogeliminar/$1');

/* FIN  RUTAS DASHBOARD */
$routes->post('/ServerSideList', 'Familia::ServerSideList');
$routes->post('/ServerSideListV2', 'Familia::ServerSideListV2');
$routes->post('/vista2serverside', 'Familia::vista2serverside');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
