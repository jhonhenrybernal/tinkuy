<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use App\Mail\VendorLeadWelcomeMail;
use App\Mail\VendorLeadAdminNotificationMail;

class VendorController extends Controller
{
    public function templateCompany(Request $request, int $id)
    {
        // 1. Buscar el vendor o 404
        $vendor = Vendor::findOrFail($id);

        // 2. Determinar qué plantilla usar:
        //    - Si viene ?page_type=... (por los radios de vista previa), usar esa
        //    - Si no, usar la que está guardada en la BD
        $pageType = $request->query('page_type', $vendor->page_type ?? 'landing_1');

        $view = match ($pageType) {
            'landing_2' => 'themes.xylo.vendor_templates.landing_2',
            'landing_3' => 'themes.xylo.vendor_templates.landing_3',
            default     => 'themes.xylo.vendor_templates.landing_1',
        };

        // 3. Datos básicos
        $companyName = $vendor->name ?? 'Demo Company';

        $logoUrl = $vendor->profile_image
            ? url('storage/' . $vendor->profile_image)
            : asset('images/defaults/vendor-logo.png');

        $description = $vendor->description
            ?? 'Texto descriptivo de la empresa y sus productos. Esta es una descripción de ejemplo por defecto.';

        // 4. Media (banners + imágenes empresa) desde company_media
        $media = $vendor->company_media ?? [];

        $bannerImages = collect($media['banners'] ?? [])
            ->map(fn($i) => url('storage/'.$i['path']))
            ->values()
            ->all();

        $companyMedia = collect($media['company_images'] ?? [])
        ->map(function ($item) {
            $path = $item['path'] ?? '';
            $url  = url('storage/' . $path);

            return [
                'url'      => $url,
                'is_video' => str_ends_with(strtolower($path), '.mp4'),
            ];
        })
        ->values()
        ->all();


        // 5. Productos demo (luego se pueden cambiar por productos reales del vendor)
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
            'companyMedia'  => $companyMedia, 
            'products'      => $products,
        ]);
    }

    public function wantSell()
    {
        return view('want-sell');
    }

    public function storeLead(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'full_name'     => ['required', 'string', 'max:255'],
                'email'         => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('vendors', 'email'),
                ],
                'phone'         => [
                    'nullable',
                    'string',
                    'max:30',
                    Rule::unique('vendors', 'phone')->whereNotNull('phone'),
                ],
                'city'          => ['nullable', 'string', 'max:120'],
                'brand_name'    => ['nullable', 'string', 'max:255'],
                'business_type' => ['nullable', 'string', 'max:100'],
                'vendor_type'   => ['required', 'in:informal,natural,juridica'],
                'social'        => ['nullable', 'string', 'max:255'],
                'about'         => ['nullable', 'string', 'max:1000'],
            ],[
                'email.unique' => 'Este correo ya está registrado en la plataforma.',
                'phone.unique' => 'Este número ya está registrado en la plataforma.',
            ]);

            if ($validator->fails()) {

                Log::warning('Error al registrar vendor lead', [
                    'errors' => $validator->errors()->toArray(),
                    'input'  => $request->except('_token'),
                ]);

                return back()
                    ->withErrors($validator)
                    ->withInput()
                    ->withFragment('vendor-apply-form');
            }


            $data = $validator->validated();

            // Crear Vendor Prospecto
            $temporaryPassword = Str::random(12) . '!';

            $vendor = Vendor::create([
                'name'   => trim($data['full_name']),
                'email'  => strtolower(trim($data['email'])),
                'password' => Hash::make($temporaryPassword),

                'phone'       => $data['phone'] ?? null,
                'status'      => 'active',
                'description' => $data['about'] ?? null,
                'page_type'   => 'landing_1',

                'vendor_type' => $data['vendor_type'],
                'brand_name'  => $data['brand_name'] ?? null,
                'city'        => $data['city'] ?? null,

                'billing_provider' => 'internal',
                'billing_user'     => null,
                'billing_notes'    => null,

                'terms_accepted' => false,
                'is_prospect'    => true,
            ]);

            // (Si luego usarás VendorLead, aquí podrías crearlo si quieres)
            // $lead = VendorLead::create([...]);
            // $lead->vendor_id = $vendor->id;
            // $lead->save();

            // Correos
           try {
                Mail::to($vendor->email)->send(
                    new VendorLeadWelcomeMail($vendor)
                );

                $adminEmail = config('mail.admin_address');
                Mail::to($adminEmail)->send(
                    new VendorLeadAdminNotificationMail($vendor)
                );
                
            } catch (\Throwable $mailError) {
                Log::error('Error enviando correos de vendor lead', [
                    'message' => $mailError->getMessage(),
                    'trace'   => $mailError->getTraceAsString(),
                ]);
                // No hacemos return, solo logueamos. El usuario verá el mensaje de éxito igualmente.
            }

            return redirect()
                ->to(url()->previous())
                ->withFragment('vendor-apply-form')
                ->with('success', 'Tu solicitud fue enviada correctamente. Nuestro equipo te contactará muy pronto.');

        } catch (\Throwable $e) {

            Log::error('Error al registrar vendor lead', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return back()
                ->withInput()
                ->withFragment('vendor-apply-form')
                ->with('error', 'Ocurrió un error al registrar tu solicitud. Intenta de nuevo en unos minutos o contáctanos.');
        }
    }

}
