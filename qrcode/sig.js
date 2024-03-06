const canvas = document.querySelector('canvas');
const form = document.querySelector('.signature-pad-form');
const clearButton = document.querySelector('.clear-button');
const ctx = canvas.getContext('2d');
let writingMode = false;

form.addEventListener('submit', (event) => {
  event.preventDefault();
  const imageData = canvas.toDataURL();

  // Add Content-Type header for base64 image data
  const headers = {
    'Content-Type': 'application/x-www-form-urlencoded'
  };

  axios.post('submit.php', { image: imageData, action: 'submit' }, { headers })
    .then(response => {
      console.log('Image successfully submitted');
      clearPad();
    })
    .catch(error => {
      console.error('Error submitting image:', error);
    });
});

const clearPad = () => {
  ctx.clearRect(0, 0, canvas.width, canvas.height);
}

clearButton.addEventListener('click', (event) => {
  event.preventDefault();
  clearPad();
});

const getTargetPosition = (event) => {
  const rect = event.target.getBoundingClientRect();
  return {
    x: event.clientX - rect.left,
    y: event.clientY - rect.top
  };
}

const handlePointerMove = (event) => {
  if (!writingMode) return;

  const position = getTargetPosition(event);
  ctx.lineTo(position.x, position.y);
  ctx.stroke();
}

const handlePointerUp = () => {
  writingMode = false;
}

const handlePointerDown = (event) => {
  writingMode = true;
  ctx.beginPath();

  const position = getTargetPosition(event);
  ctx.moveTo(position.x, position.y);
}

ctx.lineWidth = 1;
ctx.lineJoin = ctx.lineCap = 'round';

canvas.addEventListener('pointerdown', handlePointerDown, { passive: true });
canvas.addEventListener('pointerup', handlePointerUp, { passive: true });
canvas.addEventListener('pointermove', handlePointerMove, { passive: true });
