<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === config('app.name'))
<img src="https://www.clafiya.com/img/logo.svg" class="logo" alt="{{config('app.name')}} Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
