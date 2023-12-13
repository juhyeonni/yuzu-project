<header class="text-gray-600 body-font-medium">
  <div class="container mx-auto flex flex-wrap p-5 flex-col md:flex-row items-center transition gap-x-8 gap-y-4">
    <a
      href="/"
      class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0 "
    >
      <span class="hover:animate-wrongValue"><x-icon-logo /></span>
      <span class="ml-3 text-xl">{{$title}}</span>
    </a>
    <nav class="gap-16 flex flex-wrap items-center text-base">
      <a href="{{route('posts')}}">게시물</a>
      <a href="{{route('ranking')}}">랭킹</a>
    </nav>
    <nav class="md:ml-auto gap-4 flex flex-wrap items-center text-base justify-center">
      <button id="btnSearch" class="focus:animate-search"><x-icon-search /></button>
    </nav>
    <div class="flex items-center">
      @if (auth()->check())
        <a href="{{route('profile', auth()->user()->username)}}" class='mx-4 my-1 hover:text-gray-900 flex items-center'>
          @if ($user->photo)
            <img src="{{$user->photo}}" alt="p" class="w-8 h-8 rounded-full">
          @else
            <div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center">
              <span class="text-gray-500 text-2xl">{{$user->name[0]}}</span>
            </div>
          @endif
        </a>
        <a href="/logout" class='mx-4 my-1 hover:text-gray-900'>logout</a>
      @else
        <a href="/login">login now</a>
      @endif
    </div>

  </div>
</header>

<script>
  class Modal extends HTMLDivElement {
    constructor({element}) {
      super();

      this.classList.add('fixed', 'flex', 'w-screen', 'h-screen', 'top-0', 'left-0', 'bg-black', 'bg-opacity-50', 'z-50', 'hidden');

      this.appendChild(element);

      this.addEventListener('click', this.close.bind(this));
    }

    close(e) {
      if (e.target === this) {
        this.classList.add('hidden');
      }
    }
  }
  customElements.define('x-modal', Modal, {extends: 'div'});


  class SearchBtn {
    constructor({element}) {
      this.element = element;

      this.window = new SearchWindow();
      this.modal = new Modal({
        element: this.window
      });

      this.element.addEventListener('click', this.searchOpen.bind(this));

      this.element.parentElement.appendChild(this.modal);
    }

    searchOpen() {
      this.modal.classList.toggle('hidden');
    }
  }

  class SearchWindow extends HTMLDivElement {
    constructor() {
      super();
      this.keyword = '';
      this.paginate = {};

      this.timer = null;

      this.classList.add('m-auto', 'mt-16', 'max-w-2xl', 'w-full', 'flex', 'justify-center', 'items-center');

      this.innerHTML = `
        <div class="transition">
          <div class='bg-white p-4 rounded-md shadow-lg text-center animate-modalOpen'>
            <input type="text" name="search" id="search" class="w-96 md:w-fullborder py-2 px-3 mb-4 border border-slate-300" placeholder="검색어를 입력하세요." autocomplete="off" />

            <div id="result"></div>
          </div>
        </div>
      `

      this.searchInput = this.querySelector('#search');
      this.resultDiv = this.querySelector('#result');

      this.searchInput.addEventListener('keyup', this.search.bind(this));
    }

    async updateDatas() {
      const res = await fetch(`/api/posts/search?keyword=${this.keyword}`,
        {
          method: 'GET',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
        }
      );
      const datas = await res.json();

      this.paginate = datas;

      await this.render();
    }

    search(e) {
      this.keyword = e.target.value;

      if (this.timer) {
        clearTimeout(this.timer);
      }

      this.timer = setTimeout(() => {
        this.updateDatas();
      }, 500);
    }

    async render() {
      this.resultDiv.innerHTML = this.paginate.data.length === 0 ?  `
          <div class="flex flex-col mb-4">
            <span class="text-gray-500 text-sm">검색 결과가 없습니다.</span>
          </div>
        ` : `
        ${this.paginate.data.map(data => {
          const formattedDate = new Date(data.created_at).toLocaleString();
          return `
            <a href="/posts/${data.id}" class="flex flex-col mb-4">
              <span class="hover:text-gray-900">${data.title}</span>
              <p class="max-w-sm text-gray-500 text-sm overflow-hidden overflow-ellipsis">${data.content}</p>
              <span class="text-gray-500 text-sm">${formattedDate}</span>
            </a>
          `
        }).join('')}
        `;
    }
  }

  customElements.define('x-search-window', SearchWindow, {extends: 'div'});

  const originSearchBtn = document.querySelector('#btnSearch');

  new SearchBtn({
    element: originSearchBtn
  });
</script>
