<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class VendorController extends Controller
{
    public function index()
    {
        return view('admin.vendors.index');
    }

    public function create()
    {
        return view('admin.vendors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:vendors,email'],
            'password' => ['required', 'confirmed', Password::min(8)->symbols()],
            'phone'    => ['nullable', 'string', 'max:20'],
            'status'   => ['required', 'in:active,inactive,banned'],

            'profile_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'description'   => ['nullable', 'string'],
            'page_type'     => ['required', 'in:landing_1,landing_2,landing_3'],

            // campos simples para “parametrizar” company_media
            'banners.*'          => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'company_images.*'   => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        // Logo
        $profileImagePath = null;
        if ($request->hasFile('profile_image')) {
            $profileImagePath = $request->file('profile_image')->store('vendors/logo', 'public');
        }

          // company_media a partir de paths que ya creó resizeMedia
        $companyMedia = [];

        if ($request->filled('banners_paths')) {
            $companyMedia['banners'] = collect($request->input('banners_paths', []))
                ->filter()
                ->map(fn ($path) => ['path' => $path])
                ->values()
                ->all();
        }

        if ($request->filled('company_images_paths')) {
            $companyMedia['company_images'] = collect($request->input('company_images_paths', []))
                ->filter()
                ->map(fn ($path) => ['path' => $path])
                ->values()
                ->all();
        }

        Vendor::create([
            'name'          => trim($validated['name']),
            'email'         => strtolower(trim($validated['email'])),
            'password'      => bcrypt($validated['password']),
            'phone'         => $validated['phone'] ?? null,
            'status'        => $validated['status'],
            'profile_image' => $profileImagePath,
            'description'   => $validated['description'] ?? null,
            'page_type'     => $validated['page_type'],
            'company_media' => $companyMedia,   // 👈 se guarda JSON
        ]);


        return redirect()->route('admin.vendors.index')
            ->with('success', 'Proveedor creado correctamente.');
    }

    public function edit($id)
    {
        $vendor = Vendor::findOrFail($id);

        return view('admin.vendors.edit', compact('vendor'));
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
        ]);

        $data = [
            'name'        => trim($validated['name']),
            'email'       => strtolower(trim($validated['email'])),
            'phone'       => $validated['phone'] ?? null,
            'status'      => $validated['status'],
            'description' => $validated['description'] ?? null,
            'page_type'   => $validated['page_type'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        if ($request->hasFile('profile_image')) {
            if ($vendor->profile_image) {
                Storage::disk('public')->delete($vendor->profile_image);
            }
            $data['profile_image'] = $request->file('profile_image')->store('vendors', 'public');
        }

        if ($request->filled('banners_paths')) {
            $companyMedia['banners'] = collect($request->input('banners_paths', []))
                ->filter()
                ->map(fn ($path) => ['path' => $path])
                ->values()
                ->all();
        }

        if ($request->filled('company_images_paths')) {
            $companyMedia['company_images'] = collect($request->input('company_images_paths', []))
                ->filter()
                ->map(fn ($path) => ['path' => $path])
                ->values()
                ->all();
        }

        $data['company_media'] = $companyMedia;


        $vendor->update($data);

        return redirect()->route('admin.vendors.index')
            ->with('success', 'Proveedor actualizado correctamente.');
    }

    /**
     * Vista previa de la plantilla de vendor.
     * Si se pasa vendor_id, usa sus datos; si no, usa demo.
     */
    public function templatePreview(string $pageType, Request $request)
    {
        // vendor_id viene en query: ?vendor_id=123
        $vendorId = $request->get('vendor_id');
        $vendor   = $vendorId ? Vendor::find($vendorId) : null;

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
        $products = $vendor->products()   // ajusta al nombre de la relación real
        // ->where('is_featured', 1)  ⛔ NO
        ->where('status', 'active')   // opcional, si tienes campo de estado
        ->with(['translation', 'primaryImage', 'primaryVariant']) // ajusta a tus relaciones
        ->orderByDesc('created_at')
        ->take(12)                    // límite razonable para la landing
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


    public function getVendorData()
    {
        $vendors = Vendor::select(['id', 'name', 'email', 'phone', 'status']);

        return DataTables::of($vendors)
            ->addColumn('action', function ($vendor) {
                // AQUÍ está el problema:
                // $editUrl = route('vendors.edit', $vendor->id);

                $editUrl = route('admin.vendors.edit', $vendor->id); // ← usa el nombre correcto

                return '
                    <a href="'.$editUrl.'" class="border border-primary dt-edit rounded-3 d-inline-block me-2 px-2 py-1">
                        <i class="bi bi-pencil-fill text-primary"></i>
                    </a>
                    <span class="border border-danger dt-trash rounded-3 d-inline-block px-2 py-1"
                        onclick="deleteVendor('.$vendor->id.')">
                        <i class="bi bi-trash-fill text-danger"></i>
                    </span>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
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

}
