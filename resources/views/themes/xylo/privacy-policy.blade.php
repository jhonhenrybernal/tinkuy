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
                    <p class="text-muted mb-0">NOKAY</p>
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
                                En cumplimiento de lo dispuesto en la Ley 1581 de 2012, el Decreto 1377 de 2013 y demás normas concordantes,
                                NOKAY adopta la presente Política de Privacidad y Tratamiento de Datos Personales, la cual regula la recolección,
                                uso, almacenamiento, circulación y protección de los datos personales de los usuarios que acceden y utilizan la
                                plataforma digital, en adelante “la Plataforma”.
                            </p>

                            <div class="alert alert-light border mb-4">
                                <i class="fa fa-circle-info me-2"></i>
                                La aceptación de esta Política es obligatoria para compradores y vendedores, independientemente de que estos sean
                                personas naturales, personas jurídicas o vendedores informales.
                            </div>

                            <h4 id="responsable" class="mt-4">1. Responsable del tratamiento</h4>
                            <p class="text-muted">
                                NOKAY será el responsable del tratamiento de los datos personales recolectados a través de la Plataforma, y actuará
                                conforme a los principios de legalidad, finalidad, libertad, veracidad, transparencia, acceso y circulación restringida,
                                seguridad y confidencialidad.
                            </p>

                            <h4 id="titulares" class="mt-4">2. Titulares de la información</h4>
                            <p class="text-muted">
                                Son titulares de los datos personales todas las personas que se registren o utilicen la Plataforma, incluyendo:
                            </p>
                            <ul class="text-muted">
                                <li>Compradores.</li>
                                <li>Vendedores personas naturales.</li>
                                <li>Vendedores personas jurídicas, a través de sus representantes legales.</li>
                                <li>Vendedores informales.</li>
                            </ul>
                            <p class="text-muted">
                                Cada titular suministra sus datos bajo su propia responsabilidad y declara contar con la autorización necesaria cuando
                                actúe en nombre de terceros.
                            </p>

                            <h4 id="datos" class="mt-4">3. Datos personales recolectados</h4>
                            <p class="text-muted">
                                NOKAY podrá recolectar y tratar, entre otros, los siguientes datos:
                            </p>
                            <ul class="text-muted">
                                <li>Datos de identificación y contacto.</li>
                                <li>Información de registro y autenticación.</li>
                                <li>Datos financieros y de pago.</li>
                                <li>Información transaccional.</li>
                                <li>Datos técnicos y de navegación.</li>
                                <li>Información comercial relacionada con productos ofrecidos o adquiridos.</li>
                            </ul>
                            <p class="text-muted">
                                En el caso de vendedores informales, los datos serán tratados exclusivamente para fines de identificación, control operativo
                                y cumplimiento normativo.
                            </p>

                            <h4 id="autorizacion" class="mt-4">4. Autorización para el tratamiento</h4>
                            <p class="text-muted">
                                El titular autoriza de manera previa, expresa, informada e inequívoca a NOKAY para tratar sus datos personales conforme
                                a esta Política. Dicha autorización se entiende otorgada mediante el registro, aceptación expresa o uso continuado de la Plataforma.
                            </p>

                            <h4 id="finalidades" class="mt-4">5. Finalidades del tratamiento</h4>
                            <p class="text-muted mb-2">Los datos personales serán tratados para las siguientes finalidades:</p>
                            <ul class="text-muted">
                                <li>Gestionar el registro y administración de usuarios.</li>
                                <li>Facilitar la intermediación entre compradores y vendedores.</li>
                                <li>Procesar pagos, cobros y transacciones.</li>
                                <li>Verificar identidad y prevenir fraudes.</li>
                                <li>Permitir la comunicación entre usuarios dentro de la Plataforma.</li>
                                <li>Cumplir obligaciones legales, contractuales y regulatorias.</li>
                                <li>Enviar comunicaciones operativas, informativas o comerciales relacionadas con el servicio.</li>
                                <li>Atender peticiones, quejas y reclamos.</li>
                            </ul>

                            <h4 id="tipo" class="mt-4">6. Tratamiento según tipo de usuario</h4>
                            <p class="text-muted">
                                Los datos de los compradores serán utilizados para gestionar compras, pagos, entregas y atención de solicitudes.
                            </p>
                            <p class="text-muted">
                                Los datos de los vendedores personas naturales y jurídicas serán utilizados para la publicación de productos, gestión de ventas,
                                pagos, cumplimiento de obligaciones comerciales y operativas.
                            </p>
                            <p class="text-muted">
                                Los datos de los vendedores informales serán tratados con fines de identificación, control de límites operativos y prevención de riesgos,
                                sin que ello implique vínculo laboral, societario o representación legal con NOKAY.
                            </p>

                            <h4 id="transferencia" class="mt-4">7. Transferencia y transmisión de datos</h4>
                            <p class="text-muted">
                                NOKAY podrá transmitir o transferir datos personales a terceros proveedores tecnológicos, pasarelas de pago, servicios de almacenamiento o
                                autoridades competentes, cuando sea necesario para la operación de la Plataforma o por obligación legal, garantizando niveles adecuados de protección.
                            </p>

                            <h4 id="seguridad" class="mt-4">8. Seguridad de la información</h4>
                            <p class="text-muted">
                                NOKAY adopta medidas técnicas, administrativas y organizativas razonables para proteger los datos personales. No obstante, el titular reconoce que
                                ningún sistema es completamente infalible y exonera a NOKAY de responsabilidad por eventos derivados de causas ajenas a su control razonable.
                            </p>

                            <h4 id="derechos" class="mt-4">9. Derechos del titular</h4>
                            <p class="text-muted">
                                El titular podrá ejercer sus derechos de acceso, actualización, rectificación, supresión y revocatoria de la autorización, conforme a los procedimientos
                                establecidos por la normativa vigente en Colombia.
                            </p>

                            <h4 id="conservacion" class="mt-4">10. Conservación de la información</h4>
                            <p class="text-muted">
                                Los datos personales serán conservados durante el tiempo necesario para cumplir las finalidades del tratamiento, las obligaciones legales y mientras exista
                                una relación activa con la Plataforma.
                            </p>

                            <h4 id="cookies" class="mt-4">11. Uso de cookies y tecnologías similares</h4>
                            <p class="text-muted">
                                NOKAY podrá utilizar cookies y tecnologías similares para el correcto funcionamiento de la Plataforma, análisis de uso y mejora de la experiencia del usuario.
                            </p>

                            <h4 id="modificaciones" class="mt-4">12. Modificaciones</h4>
                            <p class="text-muted">
                                NOKAY se reserva el derecho de modificar esta Política de Privacidad en cualquier momento. Las modificaciones entrarán en vigor desde su publicación en la Plataforma.
                            </p>

                            <h4 id="vigencia" class="mt-4">13. Vigencia</h4>
                            <p class="text-muted mb-0">
                                La presente Política de Privacidad rige a partir de su publicación y permanecerá vigente mientras el usuario haga uso de la Plataforma.
                            </p>

                        </div>
                    </div>

                    {{-- Pie con “contactos del sistema” --}}
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
                            <li class="mb-2"><a class="text-decoration-none" href="#titulares">2. Titulares de la información</a></li>
                            <li class="mb-2"><a class="text-decoration-none" href="#datos">3. Datos personales recolectados</a></li>
                            <li class="mb-2"><a class="text-decoration-none" href="#autorizacion">4. Autorización</a></li>
                            <li class="mb-2"><a class="text-decoration-none" href="#finalidades">5. Finalidades</a></li>
                            <li class="mb-2"><a class="text-decoration-none" href="#tipo">6. Tratamiento por tipo de usuario</a></li>
                            <li class="mb-2"><a class="text-decoration-none" href="#transferencia">7. Transferencia y transmisión</a></li>
                            <li class="mb-2"><a class="text-decoration-none" href="#seguridad">8. Seguridad</a></li>
                            <li class="mb-2"><a class="text-decoration-none" href="#derechos">9. Derechos del titular</a></li>
                            <li class="mb-2"><a class="text-decoration-none" href="#conservacion">10. Conservación</a></li>
                            <li class="mb-2"><a class="text-decoration-none" href="#cookies">11. Cookies</a></li>
                            <li class="mb-2"><a class="text-decoration-none" href="#modificaciones">12. Modificaciones</a></li>
                            <li><a class="text-decoration-none" href="#vigencia">13. Vigencia</a></li>
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
