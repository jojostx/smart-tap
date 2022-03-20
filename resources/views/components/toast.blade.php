@props(['type', 'hasCloseButton'])

@php

$baseClasses = "inline-flex flex-shrink-0 rounded-lg justify-center items-center w-8 h-8 ";

switch ($type) {
    case 'success':
        $classes = $baseClasses.'text-green-500 bg-green-100 dark:bg-green-800 dark:text-green-200';
        $icon = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
        break;
    case 'danger':
        $classes = $baseClasses.'text-red-500 bg-red-100 dark:bg-red-800 dark:text-red-200';
        $icon = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
        break;
    case 'warning':
        $classes = $baseClasses.'text-orange-500 bg-orange-100 dark:bg-orange-800 dark:text-orange-200';
        $icon = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>';
        break;
    default:
        $classes = $baseClasses.'text-blue-500 bg-blue-100 dark:bg-blue-800 dark:text-blue-200';
        $icon = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
        break;
}
@endphp

<div x-data="{ show: false }" x-cloak x-show="show" @open-toast.window="show = true; $refs.toast_content.innerText = $event.detail.message" @close-alert.window="show = false" class="fixed z-50 bottom-5 right-5 flex items-center p-4 mb-4 w-full max-w-sm sm:max-w-md text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800" role="alert">
  <div {{ $attributes->merge(['class' => $classes]) }}>
    {!! $icon !!}
  </div>
  <div x-ref="toast_content" class="ml-3 text-sm font-normal">{{ $slot }}</div>

  @if ($hasCloseButton)
    <button type="button" @click="show = false"  aria-label="close" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700">
      <span class="sr-only">Close</span>
      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
      </svg>
    </button>
  @endif
</div>