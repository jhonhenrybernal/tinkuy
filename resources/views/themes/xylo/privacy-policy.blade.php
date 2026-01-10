@extends('themes.xylo.layouts.master')

@section('title', 'Política de Privacidad')

@section('content')
    {{-- Banner superior (igual estilo XYLO) --}}
    <section class="banner-area inner-banner pt-5 animate__animated animate__fadeIn productinnerbanner">
        <div class="container h-100">
            <div class="row">
                <div class="col-md-10">
                    <div class="breadcrumbs">
                        <a href="{{ route('xylo.home') }}">Inicio</a>
                        <i class="fa fa-angle-right"></i>
                        Política de Privacidad
                    </div>

                    <h1 class="mt-3">Política de Privacidad y Tratamiento de Datos Personales</h1>
                    <p class="text-muted mb-0">TINKUY</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Contenido --}}
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                {{-- Columna principal --}}
                <div class="col-lg-8">

                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4 p-lg-5">

                            <p class="text-muted mb-4">
                                En cumplimiento de lo dispuesto en la Ley 1581 de 2012, el Decreto 1377 de 2013 y las demás normas
                                que regulan la protección de datos personales en la República de Colombia, TINKUY adopta la presente
                                Política de Privacidad y Tratamiento de Datos Personales, la cual regula la recolección, almacenamiento,
                                uso, circulación y supresión de los datos personales de los usuarios que acceden y utilizan la plataforma digital.
                            </p>

                            <div class="alert alert-light border mb-4">
                                <i class="fa fa-circle-info me-2"></i>
                                La aceptación de esta Política es requisito indispensable para el registro y uso de la plataforma.
                            </div>

                            <h4 id="responsable" class="mt-4">1. Responsable del tratamiento</h4>
                            <p class="text-muted">
                                TINKUY será el responsable del tratamiento de los datos personales recolectados a través de la plataforma,
                                actuando conforme a los principios de legalidad, finalidad, libertad, veracidad, transparencia, acceso y
                                circulación restringida, seguridad y confidencialidad.
                            </p>

                            <h4 id="datos" class="mt-4">2. Datos personales objeto de tratamiento</h4>
                            <p class="text-muted">
                                TINKUY podrá recolectar, almacenar y tratar datos personales suministrados por los usuarios, incluyendo datos
                                de identificación, contacto, información financiera o bancaria, datos transaccionales, información de navegación,
                                registros de actividad y cualquier otro dato necesario para la correcta operación de la plataforma.
                            </p>
                            <p class="text-muted">
                                El tratamiento de datos sensibles o de menores de edad se realizará únicamente cuando exista autorización expresa
                                y conforme a los requisitos legales aplicables.
                            </p>

                            <h4 id="autorizacion" class="mt-4">3. Autorización del titular</h4>
                            <p class="text-muted">
                                El usuario autoriza de manera previa, expresa, informada e inequívoca a TINKUY para realizar el tratamiento de
                                sus datos personales conforme a las finalidades descritas en la presente Política.
                            </p>
                            <p class="text-muted">
                                La autorización se entenderá otorgada mediante el registro, aceptación expresa o uso continuo de la plataforma.
                            </p>

                            <h4 id="finalidades" class="mt-4">4. Finalidades del tratamiento</h4>
                            <p class="text-muted mb-2">
                                Los datos personales serán tratados para las siguientes finalidades, sin limitarse a ellas:
                            </p>
                            <ul class="text-muted">
                                <li>Gestionar el registro, autenticación y administración de cuentas de usuario.</li>
                                <li>Facilitar la intermediación entre compradores y vendedores.</li>
                                <li>Procesar pagos, cobros y transacciones.</li>
                                <li>Verificar identidad, prevenir fraudes y garantizar la seguridad de la plataforma.</li>
                                <li>Cumplir obligaciones legales, contractuales y regulatorias.</li>
                                <li>Enviar comunicaciones informativas, operativas o comerciales relacionadas con el servicio.</li>
                                <li>Atender peticiones, quejas y reclamos.</li>
                            </ul>

                            <h4 id="transferencia" class="mt-4">5. Transferencia y transmisión de datos</h4>
                            <p class="text-muted">
                                TINKUY podrá transmitir o transferir datos personales a terceros nacionales o internacionales cuando sea necesario
                                para la prestación del servicio, tales como proveedores tecnológicos, pasarelas de pago o servicios de alojamiento
                                de datos, garantizando en todo caso niveles adecuados de protección de la información.
                            </p>
                            <p class="text-muted">
                                Asimismo, los datos podrán ser revelados cuando exista un requerimiento legal o judicial por parte de autoridad competente.
                            </p>

                            <h4 id="seguridad" class="mt-4">6. Seguridad de la información</h4>
                            <p class="text-muted">
                                TINKUY implementa medidas de seguridad técnicas, administrativas y organizativas razonables para proteger los datos personales
                                contra acceso no autorizado, pérdida, alteración, uso indebido o divulgación no autorizada.
                            </p>
                            <p class="text-muted">
                                No obstante, el usuario reconoce que ningún sistema es completamente seguro y exonera a TINKUY de responsabilidad por accesos no
                                autorizados derivados de ataques informáticos o causas ajenas a su control razonable.
                            </p>

                            <h4 id="derechos" class="mt-4">7. Derechos del titular</h4>
                            <p class="text-muted">
                                El titular de los datos personales podrá ejercer en cualquier momento sus derechos de acceso, actualización, rectificación,
                                supresión y revocatoria de la autorización, conforme a los procedimientos establecidos por la ley colombiana.
                            </p>
                            <p class="text-muted">
                                Las solicitudes deberán realizarse a través de los canales oficiales dispuestos por TINKUY, los cuales serán atendidos dentro de los plazos legales.
                            </p>

                            <h4 id="conservacion" class="mt-4">8. Conservación de la información</h4>
                            <p class="text-muted">
                                Los datos personales serán conservados durante el tiempo necesario para cumplir las finalidades del tratamiento, las obligaciones legales y contractuales,
                                o mientras subsista la relación entre el usuario y TINKUY.
                            </p>

                            <h4 id="cookies" class="mt-4">9. Uso de cookies y tecnologías similares</h4>
                            <p class="text-muted">
                                TINKUY podrá utilizar cookies, identificadores y tecnologías similares para el correcto funcionamiento de la plataforma, análisis de comportamiento y mejora
                                de la experiencia del usuario. El usuario podrá configurar su navegador para restringir su uso, sin que ello afecte el funcionamiento esencial del servicio.
                            </p>

                            <h4 id="modificaciones" class="mt-4">10. Modificaciones</h4>
                            <p class="text-muted">
                                TINKUY se reserva el derecho de modificar la presente Política de Privacidad en cualquier momento. Las modificaciones serán publicadas en la plataforma y
                                entrarán en vigor desde su publicación. El uso continuado del servicio constituirá aceptación de los cambios.
                            </p>

                            <h4 id="vigencia" class="mt-4">11. Vigencia</h4>
                            <p class="text-muted mb-0">
                                La presente Política de Privacidad rige a partir de su publicación y permanecerá vigente mientras el usuario mantenga una relación activa con la plataforma.
                            </p>

                        </div>
                    </div>

                    {{-- Pie con “contactos del sistema” (igual que en contacto) --}}
                    <div class="row g-4 mt-4">
                        <div class="col-md-4">
                            <div class="sidebar h-100">
                                <h5 class="mb-2"><i class="fa fa-envelope me-2"></i>Correo</h5>
                                <p class="text-muted mb-0">
                                    <a class="text-decoration-none" href="mailto:{{ $contactEmail ?? 'soporte@tudominio.com' }}">
                                        {{ $contactEmail ?? 'soporte@tudominio.com' }}
                                    </a>
                                </p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="sidebar h-100">
                                <h5 class="mb-2"><i class="fa fa-phone me-2"></i>Teléfono</h5>
                                <p class="text-muted mb-0">
                                    <a class="text-decoration-none" href="tel:{{ $contactPhone ?? '+57 300 000 0000' }}">
                                        {{ $contactPhone ?? '+57 300 000 0000' }}
                                    </a>
                                </p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="sidebar h-100">
                                <h5 class="mb-2"><i class="fa fa-circle-info me-2"></i>Información</h5>
                                <p class="text-muted mb-0">
                                    {{ $contactNote ?? 'Horario: Lunes a Viernes · 9:00 a 18:00' }}
                                </p>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Sidebar (tabla de contenidos) --}}
                <div class="col-lg-4">
                    <div class="sidebar">
                        <h5 class="mb-3"><i class="fa fa-list me-2"></i>Contenido</h5>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2"><a class="text-decoration-none" href="#responsable">1. Responsable del tratamiento</a></li>
                            <li class="mb-2"><a class="text-decoration-none" href="#datos">2. Datos personales</a></li>
                            <li class="mb-2"><a class="text-decoration-none" href="#autorizacion">3. Autorización</a></li>
                            <li class="mb-2"><a class="text-decoration-none" href="#finalidades">4. Finalidades</a></li>
                            <li class="mb-2"><a class="text-decoration-none" href="#transferencia">5. Transferencia</a></li>
                            <li class="mb-2"><a class="text-decoration-none" href="#seguridad">6. Seguridad</a></li>
                            <li class="mb-2"><a class="text-decoration-none" href="#derechos">7. Derechos del titular</a></li>
                            <li class="mb-2"><a class="text-decoration-none" href="#conservacion">8. Conservación</a></li>
                            <li class="mb-2"><a class="text-decoration-none" href="#cookies">9. Cookies</a></li>
                            <li class="mb-2"><a class="text-decoration-none" href="#modificaciones">10. Modificaciones</a></li>
                            <li><a class="text-decoration-none" href="#vigencia">11. Vigencia</a></li>
                        </ul>
                    </div>

                    <div class="sidebar mt-4">
                        <h5 class="mb-2"><i class="fa fa-file-signature me-2"></i>Actualización</h5>
                        <p class="text-muted mb-0">
                            Vigente desde: <strong>{{ $policyDate ?? now()->format('Y-m-d') }}</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
