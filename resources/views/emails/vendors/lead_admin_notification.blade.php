@component('mail::message')
# Nuevo prospecto de proveedor

Se ha registrado una nueva persona interesada en vender en la plataforma.

@component('mail::panel')
**Nombre:** {{ $lead->full_name }}  
**Correo:** {{ $lead->email }}  
**Teléfono:** {{ $lead->phone ?: 'No especificado' }}  
**Ciudad:** {{ $lead->city ?: 'No especificada' }}  

**Marca / negocio:** {{ $lead->brand_name ?: 'No especificado' }}  
**Tipo de proveedor:** {{ ucfirst($lead->vendor_type) }}  
**Tipo de negocio:** {{ $lead->business_type ?: 'No especificado' }}  

**Redes / web:** {{ $lead->social ?: 'No especificado' }}
@endcomponent

**Descripción / qué vende:**

@if($lead->about)
> {{ $lead->about }}
@else
_No se registró descripción._
@endif

@component('mail::button', ['url' => url('/admin/vendors')])
Ver proveedores en el panel
@endcomponent

Este proveedor se ha creado como:  
**Vendor #{{ $vendor->id }} (is_prospect = true)**.

Saludos,  
{{ config('app.name') }}
@endcomponent
