@extends('layouts.default')

@section('head.title')YUZU 게시물 작성 @endsection

@section('main')

<x-alert />

<div class="max-w-screen-md mx-auto p-6 px-4 sm:px-6 lg:px-8 bg-white rounded-lg shadow-lg">
  <form action="{{route('post_store')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div>
      <label class="block font-bold mb-2">Title:</label>
      <input type="text" name="title" id="title" class="border rounded-lg py-2 px-3 mb-4 w-full">
    </div>
    <div>
      <label class="block font-bold mb-2">Content:</label>
      <textarea name="content" id="content" cols="30" rows="10" class="border rounded-lg py-2 px-3 mb-4 w-full"></textarea>
    </div>
    <div>
      <label class="block font-bold mb-2">Images:</label>
      <button type="button" id='btnNewImage'><x-icon-upload /></button>
      <div id="images" class="flex transition"></div>
      <input type="file" name="images[]" id="uploadImage" class="border rounded-lg py-2 px-3 mb-4 w-full" hidden multiple accept=".png, .jpg, .jpeg, .gif" />
    </div>

    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Post</button>
  </form>
</div>

<script>
  class Image extends HTMLDivElement {
    constructor(file, removeFile) {
      super();
      this.removeFile = removeFile;

      this.classList.add('relative', 'mr-2', 'mb-2');

      const url = URL.createObjectURL(file);

      this.innerHTML = `
        <img src="${url}" alt="upload img" class="animate-newElement w-32 h-32 object-cover rounded-lg" />
        <button type="button" class="absolute top-0 right-0 bg-red-500 hover:bg-red-700 text-white font-bold rounded px-2 py-2" style="font-size: 0.5rem;">X</button>
      `;

      this.closeBtn = this.querySelector('button');
      this.closeBtn.addEventListener('click', () => this.destory());
    }

    destory() {
      this.removeFile();
      this.remove();
    }
  }

  window.customElements.define('x-image', Image, {extends: 'div'});

  const uploadImageEle = document.getElementById('uploadImage');
  const imagesEle = document.getElementById('images');
  const btnNewImageEle = document.getElementById('btnNewImage');
  btnNewImageEle.addEventListener('click', createImageElement);

  const images = new DataTransfer();

  function createImageElement() {
    uploadImageEle.click();
  }

  function handleUploadImage(e) {
    if (!e.target.files) return;

    [...e.target.files].forEach(file => {
      images.items.add(file);
      const removeImage = () => {
        images.items.remove(file);
        uploadImageEle.files = images.files;
      }
      imagesEle.appendChild(new Image(file, removeImage));
    });

    uploadImageEle.files = images.files;
  }

  uploadImageEle.addEventListener('change', handleUploadImage);
</script>

@endsection
