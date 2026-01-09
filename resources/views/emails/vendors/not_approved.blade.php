@component('mail::message')
# Tu solicitud requiere ajustes antes de ser aprobada

Hola **{{ $vendor->name }}**,

Gracias por tu interés en vender con **{{ config('app.name') }}**.  
Por ahora, tu solicitud **no pudo ser aprobada** porque necesitamos que ajustes algunos datos.

@component('mail::panel')
**Cambios solicitados (por favor revisa y corrige):**

@foreach($items as $it)
- **{{ $it['field_label'] ?? ($it['field_key'] ?? 'Campo') }}:** {{ $it['reason_label'] ?? ($it['reason_val'] ?? 'Motivo') }}
@endforeach
@endcomponent

@component('mail::button', ['url' => $editUrl ?? url('/')])
Ir a corregir mi información
@endcomponent

Cuando realices los ajustes, nuestro equipo revisará nuevamente tu registro.

Gracias,  
**Equipo {{ config('app.name') }}**
@endcomponent
