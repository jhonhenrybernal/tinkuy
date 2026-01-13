<?php
namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\AdminValidationField;
use App\Models\AdminValidationReason;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Mail\VendorNotApprovedMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SettingsController extends Controller
{
    public function index()
    {
        $userId = auth()->guard('vendor')->id();
        $vendor = Vendor::findOrFail($userId);
        return view('vendor.settings.index', compact('vendor'));
    }

    public function update(Request $request, $id)
    {
        $vendor = Vendor::findOrFail($id);
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:vendors,email,' . $vendor->id],
            'password' => ['nullable', 'confirmed', Password::min(8)->symbols()],
            'phone'    => ['nullable', 'string', 'max:20'],
            'status'   => ['required', 'in:active,inactive,banned'],

            'profile_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'description'   => ['nullable', 'string'],
            'page_type'     => ['required', 'in:landing_1,landing_2,landing_3'],

            'banners.*'          => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'company_images.*'   => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'vendor_type' => ['required', 'in:informal,natural,juridica'],
            'brand_name'  => ['nullable', 'string', 'max:255'],

            'personal_document_type'   => ['nullable', 'string', 'max:10'],
            'personal_document_number' => ['nullable', 'string', 'max:50'],
            'city'                     => ['nullable', 'string', 'max:100'],

            'company_name'  => ['nullable', 'string', 'max:255'],
            'company_nit'   => ['nullable', 'string', 'max:50'],
            'company_nit_dv'=> ['nullable', 'string', 'max:10'],

            'legal_representative_name'            => ['nullable', 'string', 'max:255'],
            'legal_representative_document_type'   => ['nullable', 'string', 'max:10'],
            'legal_representative_document_number' => ['nullable', 'string', 'max:50'],

            'legal_rut'     => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
            'legal_chamber' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],

            'billing_provider' => ['required', 'in:internal,sigo,alegra,other'],
            'billing_user'     => ['nullable', 'string', 'max:255'],
            'billing_notes'    => ['nullable', 'string'],

            'terms_accepted'   => ['accepted'],
            'has_delivery_provider' => ['required', 'in:0,1'],
        ]);
        


        $data = [
            'name'        => trim($validated['name']),
            'email'       => strtolower(trim($validated['email'])),
            'phone'       => $validated['phone'] ?? null,
            'status'      => $validated['status'],
            'description' => $validated['description'] ?? null,
            'page_type'   => $validated['page_type'],
            'vendor_type'                        => $validated['vendor_type'],
            'brand_name'                         => $validated['brand_name'] ?? null,
            'personal_document_type'             => $validated['personal_document_type'] ?? null,
            'personal_document_number'           => $validated['personal_document_number'] ?? null,
            'city'                               => $validated['city'] ?? null,
            'company_name'                       => $validated['company_name'] ?? null,
            'company_nit'                        => $validated['company_nit'] ?? null,
            'company_nit_dv'                     => $validated['company_nit_dv'] ?? null,
            'legal_representative_name'          => $validated['legal_representative_name'] ?? null,
            'legal_representative_document_type' => $validated['legal_representative_document_type'] ?? null,
            'legal_representative_document_number' => $validated['legal_representative_document_number'] ?? null,
            'billing_provider'                   => $validated['billing_provider'],
            'billing_user'                       => $validated['billing_user'] ?? null,
            'billing_notes'                      => $validated['billing_notes'] ?? null,
            'terms_accepted'                     => (bool) ($validated['terms_accepted'] ?? false),
            'has_delivery_provider' => (bool) $validated['has_delivery_provider'],
            
        ];
        
        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }
        if ($request->hasFile('legal_rut')) {
            $data['legal_rut'] = $request->file('legal_rut')
                ->store('vendors/legal_rut', 'public');
        }

        if ($request->hasFile('legal_chamber')) {
            $data['legal_chamber'] = $request->file('legal_chamber')
                ->store('vendors/legal_chamber', 'public');
        }
        if ($request->hasFile('profile_image')) {
            if ($vendor->profile_image) {
                Storage::disk('public')->delete($vendor->profile_image);
            }
            $data['profile_image'] = $request->file('profile_image')->store('vendors', 'public');
        }
        $companyMedia  = $vendor->company_media ?? [];   // base actual
        $mediaModified = false;
        $companyMedia  = $vendor->company_media ?? [];   // base actual
        $mediaModified = false;
        $companyMedia = $vendor->company_media ?? [];
        if (is_string($companyMedia)) {
            $decoded = json_decode($companyMedia, true);
            $companyMedia = is_array($decoded) ? $decoded : [];
        }

        $mediaModified = false;

        if ($request->filled('banners_paths')) {
            $companyMedia['banners'] = collect($request->input('banners_paths', []))
                ->filter()
                ->map(fn ($path) => ['path' => $path])
                ->values()
                ->all();
            $mediaModified = true;
        }

        if ($request->filled('company_images_paths')) {
            $companyMedia['company_images'] = collect($request->input('company_images_paths', []))
                ->filter()
                ->map(fn ($path) => ['path' => $path])
                ->values()
                ->all();
            $mediaModified = true;
        }

        if ($request->filled('admin_validations')) {
            $data['admin_validations'] = $request->input('admin_validations', []);
        }

        if ($mediaModified) {
            $data['company_media'] = $companyMedia;
        }

        $data['approval_updated_by'] = auth()->id();
        $vendor->update($data);
         if ($request->filled('admin_validations')) {
            $this->sendValidationAdmin($data,$vendor);
        }
        return redirect()->route('vendor.business.settings.edit')
            ->with('success', 'Proveedor actualizado correctamente.');
    }

         /**
     * Vista previa de la plantilla de vendor.
     * Si se pasa vendor_id, usa sus datos; si no, usa demo.
     */
    public function sendValidationAdmin($data, $vendor)
    {
        // try {
            // Traemos catálogos para convertir keys->labels
            $fieldMap = AdminValidationField::query()
                ->pluck('label', 'key')
                ->toArray();

        
            $reasonMap = AdminValidationReason::query()
                ->pluck('label', 'value')
                ->toArray();

            // Normalizamos items
            
             $fieldMap = AdminValidationField::query()
                ->pluck('label', 'key')
                ->toArray();

        
            $reasonMap = AdminValidationReason::query()
                ->pluck('label', 'value')
                ->toArray();

            // Normalizamos items
           $raw = $data['admin_validations'] ?? '[]';

// Si viene como string JSON (lo normal por ser hidden input)
if (is_string($raw)) {
    $raw = json_decode($raw, true);
}

// Si por alguna razón no decodificó bien, cae a []
if (!is_array($raw)) {
    $raw = [];
}

$items = collect($raw)
    ->filter(fn($x) => is_array($x) && !empty($x['field']) && !empty($x['reason']))
    ->map(function ($x) use ($fieldMap, $reasonMap) {
        $fieldKey    = $x['field'];
        $reasonVal   = $x['reason'];
        $fieldLabel  = $fieldMap[$fieldKey] ?? $fieldKey;
        $reasonLabel = $reasonMap[$reasonVal] ?? $reasonVal;

        if (!empty($x['custom_reason'])) {
            $reasonLabel = $x['custom_reason'];
        }

        return [
            'field_key'    => $fieldKey,
            'field_label'  => $fieldLabel,
            'reason_val'   => $reasonVal,
            'reason_label' => $reasonLabel,
        ];
    })
    ->values()
    ->all();      // Enviamos correo
            if (count($items) > 0) {
                Mail::to($vendor->email)->send(
                    new VendorNotApprovedMail($vendor, $items)
                );
        
            }

        // } catch (\Throwable $e) {
        //     Log::error('Error enviando correo de no aprobación', [
        //         'vendor_id' => $vendor->id ?? null,
        //         'message' => $e->getMessage(),
        //     ]);
        // }
    }
     public function adminValidationCatalog(Request $request)
    {
        $vendorType = $request->query('vendor_type', 'informal'); // informal|natural|juridica

        $fields = AdminValidationField::query()
            ->where('is_active', true)
            ->where(function ($q) use ($vendorType) {
                $q->where('applies_to', 'all')
                ->orWhere('applies_to', $vendorType);
            })
            ->orderBy('sort_order')
            ->orderBy('label')
            ->get(['id','key','label','applies_to']);

        $reasons = AdminValidationReason::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('label')
            ->get(['id','value','label']);

        return response()->json([
            'success' => true,
            'fields'  => $fields,
            'reasons' => $reasons,
        ]);
    }

    public function adminValidationReasonStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'label' => ['required','string','max:120'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $label = trim($request->input('label'));

        // value único y estable
        $base = Str::slug($label, '_');
        $value = $base ?: ('custom_' . Str::random(6));

        // asegurar unicidad
        $i = 1;
        while (AdminValidationReason::where('value', $value)->exists()) {
            $value = $base . '_' . $i;
            $i++;
        }

        $reason = AdminValidationReason::create([
            'value'     => $value,
            'label'     => $label,
            'is_active' => true,
            'is_system' => false,
            'sort_order'=> 999,
        ]);

        return response()->json([
            'success' => true,
            'reason'  => [
                'id'    => $reason->id,
                'value' => $reason->value,
                'label' => $reason->label,
            ],
        ]);
    }



    public function adminValidationReasonUpdate(Request $request, $id)
    {
        $reason = AdminValidationReason::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'label'     => ['required','string','max:120'],
            'is_active' => ['required','boolean'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $reason->update([
            'label' => trim($request->label),
            'is_active' => (bool)$request->is_active,
        ]);

        return back()->with('success', 'Motivo actualizado.');
    }

     public function resizeMedia(Request $request)
    {
        $request->validate([
            'type'     => 'required|in:banner,company',
            'media.*' => 'required|file|mimetypes:image/jpeg,image/png,image/jpg,image/webp,video/mp4|max:102400',
        ]);

        $type  = $request->input('type');
        $files = $request->file('media', []);

        if ($type === 'banner') {
            $minWidth     = 1200;
            $minHeight    = 350;
            $targetWidth  = 1400;
            $targetHeight = 450;
            $folder       = 'vendors/banners';
        } else {
            $minWidth     = 300;
            $minHeight    = 200;
            $targetWidth  = 600;
            $targetHeight = 400;
            $folder       = 'vendors/company';
        }

        $manager = new ImageManager(new Driver());

        $items  = [];
        $errors = [];

        foreach ($files as $index => $file) {
            try {
                $mime = $file->getMimeType() ?? '';

                // --- Si es imagen ---
                if (str_starts_with($mime, 'image/')) {
                    $image = $manager->read($file->getPathname());

                    $width  = $image->width();
                    $height = $image->height();

                    if ($width < $minWidth || $height < $minHeight) {
                        $errors[] = "La imagen #".($index+1)." es demasiado pequeña ({$width}x{$height} px). "
                                . "Debe ser al menos de {$minWidth}x{$minHeight} px.";
                        continue;
                    }

                    if ($width > $targetWidth || $height > $targetHeight) {
                        $image->scaleDown(width: $targetWidth, height: $targetHeight);
                    }

                    $filename = $folder . '/' . uniqid(($type === 'banner' ? 'banner_' : 'media_')) . '.jpg';
                    $binary   = $image->toJpeg(85);
                    Storage::disk('public')->put($filename, $binary);

                    $items[] = [
                        'path'   => $filename,
                        'url'    => url('storage/'.$filename),
                        'width'  => $image->width(),
                        'height' => $image->height(),
                        'kind'   => 'image',
                    ];
                }
                // --- Si es video MP4 (solo para type=company) ---
                elseif ($mime === 'video/mp4') {
                    if ($type === 'banner') {
                        $errors[] = "No se permiten videos en los banners (#".($index+1).").";
                        continue;
                    }

                    $storedPath = $file->store('vendors/company', 'public');

                    $items[] = [
                        'path' => $storedPath,
                        'url'  => url('storage/'.$storedPath),
                        'kind' => 'video',
                    ];
                }
                // --- Cualquier otra cosa ---
                else {
                    $errors[] = "El archivo #".($index+1)." tiene un tipo no permitido.";
                }
            } catch (\Throwable $e) {
                \Log::error('Error procesando media de vendor', [
                    'exception'  => $e,
                    'file_index' => $index,
                    'type'       => $type,
                ]);

                $errors[] = "Error procesando el archivo #".($index+1).": ".$e->getMessage();
            }
        }

        if (empty($items) && !empty($errors)) {
            return response()->json([
                'success' => false,
                'errors'  => $errors,
            ]);
        }

        return response()->json([
            'success' => true,
            'items'   => $items,
            'errors'  => $errors,
        ]);
    }

    /**
     * Vista previa de la plantilla de vendor.
     * Si se pasa vendor_id, usa sus datos; si no, usa demo.
     */
    public function templatePreview(string $pageType, Request $request)
    {
        // vendor_id viene en query: ?vendor_id=123
        $vendorId = $request->get('vendor_id');
        $vendor   = Vendor::findOrFail($vendorId);

        // Escogemos la vista según el tipo de landing
        $view = match ($pageType) {
            'landing_2' => 'themes.xylo.vendor_templates.landing_2',
            'landing_3' => 'themes.xylo.vendor_templates.landing_3',
            default     => 'themes.xylo.vendor_templates.landing_1',
        };

        // Si no hay vendor, usamos solo los defaults de la plantilla
        if (!$vendor) {
            return view($view);
        }

        // Datos básicos
        $companyName = $vendor->name ?? 'Demo Company';

        $logoUrl = $vendor->profile_image
            ? url('storage/' . $vendor->profile_image)
            : asset('images/defaults/vendor-logo.png');

        $description = $vendor->description
            ?? 'Texto descriptivo de la empresa y sus productos. Esta es una descripción de ejemplo por defecto.';

        // Media desde company_media (asegúrate de tener $casts['company_media' => 'array'] en el modelo)
        $media = $vendor->company_media ?? [];

        $bannerImages = collect($media['banners'] ?? [])
            ->map(fn($i) => url('storage/'.$i['path']))
            ->values()
            ->all();

        $companyImages = collect($media['company_images'] ?? [])
            ->map(function($i){
                $url = url('storage/'.$i['path']);

                return [
                    'url'  => $url,
                    'is_video' => str_ends_with(strtolower($i['path']), '.mp4'),
                ];
            })
            ->values()
            ->all();


        // Productos demo (luego se pueden cambiar por productos reales)
       $products = $vendor->products()
        ->where('status', 1)                    // o 'active' según tu modelo
        ->with(['translation', 'images', 'primaryVariant'])
        ->orderByDesc('created_at')
        ->take(12)
        ->get();
           
        return view($view, [
            'companyName'   => $companyName,
            'logoUrl'       => $logoUrl,
            'description'   => $description,
            'bannerImages'  => $bannerImages,
            'companyMedia'  =>  $companyImages,
            'products'      => $products,
        ]);
    }
}
