<div class="mb-3 w-96 mt-3">
    <label for="formFile" class="form-label inline-block text-gray-700">Upload PDF</label>
    <input {{ $attributes->merge(['name' => 'file', 'class' => 'form-control
    block
    w-full
    px-3
    py-1.5
    text-base
    font-normal
    text-gray-700
    bg-white bg-clip-padding
    border border-solid border-gray-300
    rounded
    transition
    ease-in-out
    m-0
    focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none'])}} type="file" id="formFile" accept="application/pdf">
</div>