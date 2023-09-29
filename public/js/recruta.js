
const error = document.querySelector('.error');
const btn = document.querySelector('.btn:last-child'),
	btn_code = document.querySelector('.btn-code'),
	container_code = document.querySelector('.container-code'),
	cat = document.querySelector('#category'),
	anounce_title = document.querySelector('#anounce_title'),
	label = document.querySelector('label[for="anounce_title"]'),
	label_1 = document.querySelector('label[for="anounce_message"]')

let index = 0;




slideShow();

setTimeout(() => {
	error.style.display = 'none';
}, 4000)

btn_code.onclick = () => {
	container_code.style.display = "none"
}


cat.onchange = (evt) => {
	switch ((evt.target.value).toLowerCase()) {
		case 'empresa':
			anounce_title.placeholder = "Título do anúncio";
			label.innerHTML = 'Título do anúncio';
			label_1.innerHTML = 'Corpo do anúncio';
			break;
		case 'candidato':
			anounce_title.placeholder = "Nome do candidato";
			label.innerHTML = 'Candidato';
			label_1.innerHTML = 'Corpo do anúncio';
			break;
		case 'mensagem':
			anounce_title.placeholder = "Nome do distinatário";
			label.innerHTML = 'Distinatário';
			label_1.innerHTML = 'Corpo da mensagem';
			break;
	}
}

async function slideShow() {
	const slide = document.querySelectorAll('.slide');
	for (var x = 0; x < slide.length; x++) {
		slide[x].style.display = 'none';
	}
	if (index >= slide.length) {
		index = 0;
	}
	index++;
	slide[index - 1].style.display = 'block';
	setTimeout(slideShow, 20000);
}

btn.onclick = () => {
	error.style.display = 'flex';
	setTimeout(() => {
		error.style.display = 'none';
	}, 3000);
}
