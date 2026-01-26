@extends('vendor.layouts.master')

@section('css')
<style>
    body {
        background-color: #ffffff;
        color: #333333;
    }

    .dashboard-item {
        display: flex;
        align-items: center;
        padding: 15px;
        border-radius: 12px;
        border: 1px solid #b0b0b0;
        background: #fff;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .dashboard-item:hover {
        background-color: #f8f9fa;
        box-shadow: 0 4px 6px rgba(102, 179, 255, 0.2);
    }

    .icon-box {
        width: 55px;
        height: 55px;
        border-radius: 50%;
        background: #e0e0e0;
        border: 1px solid #b0b0b0;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        transition: all 0.3s ease;
    }

    .dashboard-item:hover .icon-box {
        background: #66b3ff;
        border-color: #66b3ff;
    }

    .icon-box i {
        font-size: 22px;
        color: #555;
        transition: color 0.3s;
    }

    .dashboard-item:hover .icon-box i {
        color: #fff;
    }

    .text-box h6 {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
        color: #2d2d2d;
    }

    .text-box p {
        margin: 0;
        font-size: 14px;
        color: #6c757d;
    }
</style>
@endsection

@section('content')
<div class="container mt-4">
    <div class="row g-3">

        <!-- My Sales -->
        <div class="col-md-3">
            <div class="dashboard-item">
                <div class="icon-box"><i class="fas fa-dollar-sign"></i></div>
                <div class="text-box">
                    <h6>{{ __('cms.dashboard.my_sales') }}</h6>
                    <p>{{ __('cms.dashboard.today') }}: ${{ number_format($data['todaySales'], 2) }}</p>
                    <p>{{ __('cms.dashboard.total') }}: ${{ number_format($data['totalSales'], 2) }}</p>
                </div>
            </div>
        </div>

        <!-- My Orders -->
        <div class="col-md-3">
            <div class="dashboard-item">
                <div class="icon-box"><i class="fas fa-shopping-bag"></i></div>
                <div class="text-box">
                    <h6>{{ __('cms.dashboard.my_orders') }}</h6>
                    <p>{{ __('cms.dashboard.completed') }}: {{ $data['completedOrders'] }}</p>
                    <p>{{ __('cms.dashboard.total') }}: {{ $data['totalOrders'] }}</p>
                </div>
            </div>
        </div>

        <!-- My Products -->
        <div class="col-md-3">
            <div class="dashboard-item">
                <div class="icon-box"><i class="fas fa-box-open"></i></div>
                <div class="text-box">
                    <h6>{{ __('cms.dashboard.my_products') }}</h6>
                    <p>{{ __('cms.dashboard.total') }}: {{ $data['totalProducts'] }}</p>
                </div>
            </div>
        </div>

    </div>
    @if(!session('meets_requirements'))
        <div class="mt-2 alert alert-warning py-2 px-3 mb-0">
            <small>
                <strong>Política del servicio:</strong> superaste los parámetros mensuales establecidos.
                <br>
                Límite de órdenes completadas: <strong>{{ config('vendor.min_completed_orders') }}</strong> ·
                Límite de ventas: <strong>${{ number_format(config('vendor.min_wage_current'), 0) }}</strong>

                <hr class="my-2">

                <strong>Opciones disponibles:</strong>
                <ol class="mb-2 ps-3">
                    <li><strong>Esperar al próximo mes</strong> para que se reinicien los contadores mensuales.</li>
                    <li>
                        <strong>Formalizar tu actividad</strong> (persona natural o jurídica) y continuar sin restricción.

                        <div class="mt-2">
                            <div class="fw-semibold">Documentos básicos en Colombia</div>

                            <ul class="mb-2 ps-3">
                                <li><strong>Persona natural (comerciante)</strong>
                                    <ul class="mb-2 ps-3">
                                        <li>Cédula de ciudadanía (o cédula de extranjería / pasaporte si aplica).</li>
                                        <li><strong>RUT</strong> (Registro Único Tributario) actualizado.</li>
                                        <li><strong>Matrícula mercantil</strong> en Cámara de Comercio (si actúas como comerciante).</li>
                                        <li>Cuenta bancaria a tu nombre (para pagos).</li>
                                        <li>Certificación bancaria (cuando aplique).</li>
                                        <li>Responsabilidad fiscal / régimen en DIAN (según tu actividad).</li>
                                    </ul>
                                </li>

                                <li><strong>Persona jurídica (empresa)</strong>
                                    <ul class="mb-2 ps-3">
                                        <li><strong>NIT</strong> y <strong>RUT</strong> de la empresa actualizado.</li>
                                        <li><strong>Cámara de Comercio</strong>: certificado de existencia y representación legal (vigente).</li>
                                        <li>Documento del representante legal (CC/CE/PP) + datos de contacto.</li>
                                        <li>Acta o documento de constitución / estatutos (según tipo de sociedad).</li>
                                        <li>Cuenta bancaria a nombre de la empresa + certificación bancaria.</li>
                                        <li>Si aplica: autorización para facturación electrónica / proveedor tecnológico.</li>
                                    </ul>
                                </li>
                            </ul>

                            <small class="text-muted">
                                Nota: los requisitos exactos pueden variar según ciudad, actividad económica y régimen tributario.
                            </small>
                        </div>
                    </li>

                </ol>

                <button type="button"
                        class="btn btn-sm btn-outline-primary"
                        id="btn-show-terms">
                    Leer términos y condiciones
                </button>
            </small>
        </div>
    @endif
@include('vendor.layouts.partials.terms_natural')
</div>
@endsection
@section('js')
<script>
    // Si en dashboard NO tienes vendor_type por radios, lo sacas del vendor (backend)
    const DASH_VENDOR_TYPE = @json($vendor->vendor_type ?? 'natural');

    function openTermsModalDashboard() {
        // Si quieres reusar updateTermsPreview(), puedes copiar esa función aquí también.
        // Si no, simplemente abre el modal.

        let modalId = 'termsModalInformal';

        if (DASH_VENDOR_TYPE === 'natural') modalId = 'termsModalNatural';
        if (DASH_VENDOR_TYPE === 'juridica') modalId = 'termsModalJuridica';
        if (DASH_VENDOR_TYPE === 'informal') modalId = 'termsModalInformal';

        const modalEl = document.getElementById(modalId);
        if (!modalEl) return;

        let modal = bootstrap.Modal.getInstance(modalEl);
        if (!modal) modal = new bootstrap.Modal(modalEl);
        modal.show();
    }

    document.addEventListener('DOMContentLoaded', function () {
        const btnShowTerms = document.getElementById('btn-show-terms');
        if (btnShowTerms) {
            btnShowTerms.addEventListener('click', function (e) {
                e.preventDefault();
                openTermsModalDashboard();
            });
        }
    });
</script>
@endsection

