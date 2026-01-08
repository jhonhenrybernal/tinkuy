@component('mail::message')
# ¡Hola {{ $vendor->name }}!

Gracias por registrarte como **posible proveedor** en nuestra plataforma.

Hemos recibido tu información y en los próximos días nuestro equipo revisará tu solicitud
para confirmar que tu negocio encaje con lo que ofrecemos.

@component('mail::panel')
**Resumen de tu registro**

- Marca / negocio: **{{ $lead->brand_name ?: 'No especificado' }}**
- Tipo de proveedor: **{{ ucfirst($lead->vendor_type) }}**
- Ciudad: **{{ $lead->city ?: 'No especificada' }}**
- Tipo de negocio: **{{ $lead->business_type ?: 'No especificado' }}**
@endcomponent

Mientras tanto, puedes ir preparando:

- Logo de tu marca en buena calidad.  
- Algunas fotos de tus productos o servicios.  
- Información básica de precios y catálogo.

Cuando tu solicitud sea aprobada, te contactaremos por correo (o teléfono si lo proporcionaste)
para ayudarte a configurar tu tienda y completar el registro oficial.

Si tú no realizaste este registro, puedes ignorar este correo.

Saludos,  
**El equipo de {{ config('app.name') }}**
@endcomponent
