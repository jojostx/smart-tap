@props(['type', 'hasCloseButton'])

@php

$baseClasses = "fixed top-0 z-50 flex p-4 mb-4 rounded-lg w-full ";
$baseButtonClass = "ml-auto -mx-1.5 -my-1.5 rounded-lg p-1.5 inline-flex h-8 w-8 ";

switch ($type) {
    case 'success':
        $classes = $baseClasses.'bg-green-100 dark:bg-green-200 text-green-700 dark:text-green-800';
        $buttonClasses = $baseButtonClass.'bg-green-100 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 hover:bg-green-200 dark:bg-green-200 dark:text-green-600 dark:hover:bg-green-300';
        break;
    case 'danger':
        $classes = $baseClasses.'bg-red-100 dark:bg-red-200 text-red-700 dark:text-red-800';
        $buttonClasses = $baseButtonClass.'bg-red-100 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 hover:bg-red-200 dark:bg-red-200 dark:text-red-600 dark:hover:bg-red-300';   
        break;
    case 'warning':
        $classes = $baseClasses.'bg-orange-100 dark:bg-orange-200 text-orange-700 dark:text-orange-800';
        $buttonClasses = $baseButtonClass.'bg-orange-100 text-orange-500 rounded-lg focus:ring-2 focus:ring-orange-400 hover:bg-orange-200 dark:bg-orange-200 dark:text-orange-600 dark:hover:bg-orange-300';
        break;
    case 'info':
        $classes = $baseClasses.'bg-blue-100 dark:bg-blue-200 text-blue-700 dark:text-blue-800';
        $buttonClasses = $baseButtonClass.'bg-blue-100 text-blue-500 rounded-lg focus:ring-2 focus:ring-blue-400 hover:bg-blue-200 dark:bg-blue-200 dark:text-blue-600 dark:hover:bg-blue-300';
        break;
    default:
        $classes = $baseClasses.'bg-gray-100 dark:bg-gray-200 text-gray-700 dark:text-gray-800';
        $buttonClasses = $baseButtonClass.'bg-gray-100 text-gray-500 rounded-lg focus:ring-2 focus:ring-gray-400 hover:bg-gray-200 dark:bg-gray-200 dark:text-gray-600 dark:hover:bg-gray-300';
        break;
}
@endphp

<div x-data="{ show: false }" x-cloak x-show="show" @open-alert.window="show = true; $refs.alert_content.innerText = $event.detail.message" @close-alert.window="show = false" role="alert" {{ $attributes->merge(['class' => $classes]) }}>
  <div class="ml-3 text-sm font-medium w-full flex md:justify-center md:items-center">
    <svg class="flex-shrink-0 w-5 h-5 mr-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
    <div x-ref="alert_content" class="inline-flex">
      {{ $slot }}
    </div>
  </div>
  @if ($hasCloseButton)
    <button type="button" @click="show = false" aria-label="close" {{ $attributes->merge(['class' => $buttonClasses]) }}>
      <span class="sr-only">Close</span>
      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
    </button>
  @endif
</div>