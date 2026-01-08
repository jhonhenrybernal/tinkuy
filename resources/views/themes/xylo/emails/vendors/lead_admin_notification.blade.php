@component('mail::message')
# Nuevo prospecto de proveedor

Se registró un nuevo prospecto desde el landing de proveedores.

@component('mail::panel')
**Datos del prospecto**  
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
@if(!empty($vendor->description))
- **¿Qué vende?:** {{ $vendor->description }}
@endif
@endcomponent

@component('mail::button', ['url' => $adminVendorUrl ?? url('/')])
Ver en panel de administración
@endcomponent

@component('mail::button', ['url' => $landingUrl ?? url('/')])
Ir al landing de proveedores
@endcomponent

**Recuerda:** Este registro está marcado como *prospecto* y debe completarse antes de aprobarlo como proveedor.
@endcomponent
