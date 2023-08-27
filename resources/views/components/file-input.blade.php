@props(['disabled' => false,  'type' => 'file', 'accept' => false])

<input
    {{ $disabled ? 'disabled' : '' }} type="{{$type}}" {!! $attributes->merge(['class' => 'block w-full text-sm text-slate-500
      file:mr-4 file:py-2 file:px-4
      file:rounded-full file:border-0
      file:text-sm file:font-semibold
      file:bg-indigo-100 file:text-indigo-700
      hover:file:bg-indigo-200']) !!}>
