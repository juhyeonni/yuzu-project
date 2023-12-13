<div class="modal transition" key={{$key}}>
  <div class='content'>{{ $content }}</div> 
  <div class='modal flex fixed w-screen h-screen top-0 left-0 bg-black bg-opacity-50 z-50 hidden'>
    {{ $slot }}
  </div>
</div>

<script>
  (() => {
    const container = document.querySelector('.modal[key="{{$key}}"]');

    const modal = {
      element: container.querySelector('.modal'),
      handler: {
        close: () => {
          modal.element.classList.add('hidden');
        },
        open: () => {
          modal.element.classList.remove('hidden');
        }
      },
      init: () => {
        modal.element.addEventListener('click', modal.handler.close);
      }
    }

    const content = {
      element: container.querySelector('.content'),
      handler: {
        open: () => {
          modal.handler.open();
        }
      },
      init: () => {
        content.element.addEventListener('click', content.handler.open);
      }
    }

    modal.init();
    content.init();
  })();
</script>

