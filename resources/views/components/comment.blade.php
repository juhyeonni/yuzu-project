<div class='comment flex items-center mb-4' key={{$id}} >
  <div class="mr-2">
    <button class="comment-like text-black font-bold py-1 px-2 rounded-full bg-white hover:bg-gray-300">
      <span>♡</span>
    </button>
  </div>
  <div class="comment-container">
    <div class="comment-header">
      <span class="text-gray-500">{{$name}}</span>
      <span class="text-gray-500 text-xs">{{$date}}</span>
      <span class="like-count text-gray-500 text-xs">liked {{'0'}}</span>
    </div>
    <div class="comment-content">
      <span class="text-gray-500 text-sm">{{$content}}</span>
    </div>
  </div>
</div>

<script>
  const likeBtn = document.querySelector('.comment-like');
  const likeCount = document.querySelector('.like-count');
  const commentContainer = document.querySelector('.comment-container');
  const commentContent = document.querySelector('.comment-content');
  const comment = document.querySelector('.comment');

  likeBtn.addEventListener('click', async () => {
    const res = await fetch(`/comments/{{$id}}/like`, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      }
    });
    const data = await res.json();

    if (data.result === 'ok') {
      likeCount.innerText = `liked ${data.likeCount}`;
    }
  });

  commentContent.addEventListener('click', () => {
    commentContainer.classList.toggle('hidden');
  });

  comment.addEventListener('mouseover', () => {
    comment.classList.add('bg-gray-100');
  });

  comment.addEventListener('mouseout', () => {
    comment.classList.remove('bg-gray-100');
  });
</script>

