@component('mail::message')
# ¡Gracias por tu interés en vender con nosotros!

Hola **{{ $vendor->name }}**,  

Gracias por confiar en **{{ config('app.name') }}**. Hemos recibido tu solicitud para convertirte en proveedor y nuestro equipo la revisará.  
En breve nos pondremos en contacto contigo para continuar con el proceso.

@component('mail::panel')
**Resumen de tu solicitud**  
- **Nombre:** {{ $vendor->name }}  
- **Correo:** {{ $vendor->email }}  
@if(!empty($vendor->phone))
- **Teléfono / WhatsApp:** {{ $vendor->phone }}
@endif
@if(!empty($vendor->city))
- **Ciudad:** {{ $vendor->city }}
@endif
@if(!empty($vendor->brand_name))
- **Marca / negocio:** {{ $vendor->brand_name }}
@endif
@if(!empty($vendor->vendor_type))
- **Tipo de proveedor:** {{ ucfirst($vendor->vendor_type) }}
@endif
@endcomponent

@component('mail::button', ['url' => $landingUrl ?? url('/')])
Ver información para proveedores
@endcomponent

Si tienes dudas, responde este correo y con gusto te ayudamos.

Saludos,  
**Equipo {{ config('app.name') }}**
@endcomponent
