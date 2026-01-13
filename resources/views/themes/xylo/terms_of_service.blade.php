@extends('themes.xylo.layouts.master')

@section('title', 'Términos y Condiciones')

@section('content')
    {{-- Banner superior --}}
    <section class="banner-area inner-banner pt-5 animate__animated animate__fadeIn productinnerbanner">
        <div class="container h-100">
            <div class="row">
                <div class="col-md-10">
                    <div class="breadcrumbs">
                        <a href="{{ route('xylo.home') }}">Inicio</a>
                        <i class="fa fa-angle-right"></i>
                        Términos y Condiciones
                    </div>

                    <h1 class="mt-3">Términos y Condiciones Generales de Uso</h1>
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
                                Los presentes Términos y Condiciones regulan el acceso y uso de la plataforma digital NOKAY,
                                en adelante “la Plataforma”, la cual actúa como un Marketplace de intermediación que conecta
                                vendedores de productos hechos en Colombia con compradores interesados en adquirirlos.
                            </p>

                            <div class="alert alert-light border mb-4">
                                <i class="fa fa-circle-info me-2"></i>
                                Al registrarse, acceder o utilizar la Plataforma, vendedores y compradores declaran haber leído,
                                entendido y aceptado íntegramente estos Términos y Condiciones.
                            </div>

                            <h4 id="naturaleza" class="mt-4">1. Naturaleza del servicio</h4>
                            <p class="text-muted">
                                NOKAY actúa exclusivamente como un intermediario tecnológico. En ningún caso NOKAY es vendedor,
                                fabricante, distribuidor, comerciante, almacenador o propietario de los productos ofrecidos dentro
                                de la Plataforma.
                            </p>
                            <p class="text-muted">
                                Las transacciones de compraventa se realizan directamente entre vendedores y compradores,
                                siendo estos los únicos responsables de las obligaciones que se deriven de dichas transacciones.
                            </p>

                            <h4 id="usuarios" class="mt-4">2. Usuarios de la plataforma</h4>
                            <p class="text-muted">La Plataforma puede ser utilizada por los siguientes tipos de usuarios:</p>
                            <ul class="text-muted">
                                <li>Vendedores, personas naturales, jurídicas o informales.</li>
                                <li>Compradores.</li>
                            </ul>
                            <p class="text-muted">Cada usuario actúa bajo su propia responsabilidad y conforme a su condición legal.</p>

                            <h4 id="registro" class="mt-4">3. Registro y veracidad de la información</h4>
                            <p class="text-muted">
                                Los usuarios se obligan a suministrar información veraz, completa y actualizada. NOKAY podrá suspender
                                o cancelar cuentas cuando identifique información falsa, inconsistente o engañosa.
                            </p>

                            <h4 id="vendedores" class="mt-4">4. Condiciones aplicables a los vendedores</h4>
                            <p class="text-muted">Los vendedores son los únicos responsables de:</p>
                            <ul class="text-muted">
                                <li>Legalidad, origen, autenticidad y calidad de los productos.</li>
                                <li>Garantizar que los productos sean elaborados en Colombia.</li>
                                <li>Cumplimiento de normativa comercial, sanitaria, tributaria y de consumo.</li>
                                <li>Descripción correcta de precios y condiciones.</li>
                                <li>Entrega oportuna.</li>
                                <li>Garantías, devoluciones y reclamos.</li>
                            </ul>
                            <p class="text-muted">NOKAY no asume responsabilidad por incumplimientos del vendedor.</p>

                            <h4 id="informales" class="mt-4">5. Vendedores informales</h4>
                            <p class="text-muted">
                                Los vendedores informales operan bajo su propia responsabilidad. NOKAY no actúa como empleador,
                                socio, representante legal ni responsable tributario.
                            </p>
                            <p class="text-muted">
                                Podrán establecerse límites de ventas o montos, cuyo incumplimiento podrá generar suspensión o cancelación.
                            </p>

                            <h4 id="compradores" class="mt-4">6. Condiciones aplicables a los compradores</h4>
                            <ul class="text-muted">
                                <li>NOKAY no es el vendedor.</li>
                                <li>Reclamos deben dirigirse al vendedor.</li>
                                <li>No se garantiza disponibilidad ni calidad de productos de terceros.</li>
                            </ul>

                            <h4 id="pagos" class="mt-4">7. Pagos y transacciones</h4>
                            <p class="text-muted">
                                Los pagos podrán realizarse mediante pasarelas de terceros. NOKAY no es responsable por fallas
                                atribuibles a dichas plataformas.
                            </p>

                            <h4 id="responsabilidad" class="mt-4">8. Limitación de responsabilidad</h4>
                            <ul class="text-muted">
                                <li>Incumplimientos entre usuarios.</li>
                                <li>Fallas técnicas o ataques informáticos.</li>
                                <li>Acciones de terceros.</li>
                            </ul>

                            <h4 id="propiedad" class="mt-4">9. Propiedad intelectual</h4>
                            <p class="text-muted">
                                Todos los contenidos y marcas son propiedad de NOKAY o terceros autorizados y están protegidos por la ley.
                            </p>

                            <h4 id="suspension" class="mt-4">10. Suspensión y cancelación</h4>
                            <p class="text-muted">
                                NOKAY podrá suspender o cancelar cuentas que incumplan estos términos o la ley.
                            </p>

                            <h4 id="modificaciones" class="mt-4">11. Modificaciones</h4>
                            <p class="text-muted">
                                Las modificaciones entrarán en vigor desde su publicación.
                            </p>

                            <h4 id="ley" class="mt-4">12. Ley aplicable y jurisdicción</h4>
                            <p class="text-muted">
                                Se rigen por las leyes de Colombia y su jurisdicción.
                            </p>

                            <h4 id="aceptacion" class="mt-4">13. Aceptación</h4>
                            <p class="text-muted mb-0">
                                El uso de la Plataforma implica aceptación expresa de estos términos.
                            </p>

                        </div>
                    </div>

                    {{-- Contactos --}}
                    <div class="row g-4 mt-4">
                        <div class="col-md-4">
                            <div class="sidebar h-100">
                                <h5><i class="fa fa-envelope me-2"></i>Correo</h5>
                                <p class="text-muted mb-0">{{ $contactEmail ?? 'soporte@tudominio.com' }}</p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="sidebar h-100">
                                <h5><i class="fa fa-phone me-2"></i>Teléfono</h5>
                                <p class="text-muted mb-0">{{ $contactPhone ?? '+57 300 000 0000' }}</p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="sidebar h-100">
                                <h5><i class="fa fa-circle-info me-2"></i>Información</h5>
                                <p class="text-muted mb-0">{{ $contactNote ?? 'Horario: Lunes a Viernes · 9:00 a 18:00' }}</p>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Sidebar índice --}}
                <div class="col-lg-4">
                    <div class="sidebar">
                        <h5><i class="fa fa-list me-2"></i>Contenido</h5>
                        <ul class="list-unstyled mb-0">
                            <li><a href="#naturaleza">1. Naturaleza</a></li>
                            <li><a href="#usuarios">2. Usuarios</a></li>
                            <li><a href="#registro">3. Registro</a></li>
                            <li><a href="#vendedores">4. Vendedores</a></li>
                            <li><a href="#informales">5. Informales</a></li>
                            <li><a href="#compradores">6. Compradores</a></li>
                            <li><a href="#pagos">7. Pagos</a></li>
                            <li><a href="#responsabilidad">8. Responsabilidad</a></li>
                            <li><a href="#propiedad">9. Propiedad intelectual</a></li>
                            <li><a href="#suspension">10. Suspensión</a></li>
                            <li><a href="#modificaciones">11. Modificaciones</a></li>
                            <li><a href="#ley">12. Ley aplicable</a></li>
                            <li><a href="#aceptacion">13. Aceptación</a></li>
                        </ul>
                    </div>

                    <div class="sidebar mt-4">
                        <h5><i class="fa fa-file-signature me-2"></i>Actualización</h5>
                        <p class="text-muted mb-0">
                            Vigente desde: <strong>{{ $termsDate ?? now()->format('Y-m-d') }}</strong>
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
