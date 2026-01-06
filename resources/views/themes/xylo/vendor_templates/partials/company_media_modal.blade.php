{{-- resources/views/themes/xylo/vendor_templates/partials/company_media_modal.blade.php --}}

<div class="modal fade" id="companyMediaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Galería de empresa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body p-0">
                <div class="company-media-modal-wrapper">
                    {{-- Imagen grande --}}
                    <img id="companyMediaImage"
                         class="img-fluid d-none w-100"
                         alt="Media empresa">

                    {{-- Video grande --}}
                    <video id="companyMediaVideo"
                           class="w-100 d-none"
                           controls
                           playsinline>
                    </video>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .company-media-modal-wrapper {
        width: 100%;
        max-height: 80vh;
        background: #000;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .company-media-modal-wrapper img,
    .company-media-modal-wrapper video {
        max-width: 100%;
        max-height: 80vh;
        object-fit: contain;
    }

    /* Estilo para el “thumbnail” clickeable */
    .company-media-thumb {
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .company-media-thumb::after {
        content: "Ver";
        position: absolute;
        right: 8px;
        bottom: 8px;
        padding: 2px 6px;
        font-size: 11px;
        background: rgba(0,0,0,.6);
        color: #fff;
        border-radius: 4px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalEl = document.getElementById('companyMediaModal');
        if (!modalEl || !window.bootstrap) return;

        const modal  = new bootstrap.Modal(modalEl);
        const imgEl  = document.getElementById('companyMediaImage');
        const vidEl  = document.getElementById('companyMediaVideo');

        document.querySelectorAll('[data-company-media="preview"]').forEach(function (thumb) {
            thumb.addEventListener('click', function () {
                const url  = this.getAttribute('data-url');
                const type = this.getAttribute('data-type'); // image | video
                if (!url) return;

                // Reset
                imgEl.classList.add('d-none');
                vidEl.classList.add('d-none');
                vidEl.pause();
                vidEl.removeAttribute('src');
                vidEl.load();

                if (type === 'video') {
                    vidEl.setAttribute('src', url);
                    vidEl.classList.remove('d-none');
                } else {
                    imgEl.setAttribute('src', url);
                    imgEl.classList.remove('d-none');
                }

                modal.show();
            });
        });
    });
</script>
