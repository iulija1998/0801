let step = true, //ход игрока
	playerCountBalls = 10,
	compCountBalls = 10,
	playBtn = document.querySelector('.play'),
	playerBag = document.querySelector('.player-bag'),
	compImg = document.querySelector('.comp-img'),
	playerImg = document.querySelector('.player-img'),
	playerCount = document.querySelector('.player__count'),
	playerCountBtn = document.querySelector('.player__count-btn'),
	evenBtn = document.querySelector('.even'),
	oddBtn = document.querySelector('.odd'),
	playText = document.querySelector('.play__text'),
	results = document.querySelector('.game__results'),
	guessCompBalls,
	guessPlayerBalls,
	compEvenOdd,
	messages = {
		'wrong_bet': 'Неверная ставка',
		'step_456': 'Угадывает 456! <br>Сделай  ставку и выбери Четное/Нечетное',
		'win_456': 'Игра окончена! Победил 456!',
		'res_456': '456 сделал ставку',
		'step_001': 'Угадывает 111! <br>Сделай  ставку',
		'win_001': 'Игра окончена! Победил 111!',
		'res_001': '111 сделал ставку'
	};

let compTotal = document.querySelector('.comp__total'),
	playerTotal = document.querySelector('.player__total');



//запуск игры сначала
playBtn.addEventListener('click', play);
function play() {
	playBtn.classList.add('hide');
	playerCountBalls = 10;
	compCountBalls = 10;
	results.innerHTML = '';
	compImg.setAttribute('src', 'img/001-sad.jpg');
	playerImg.setAttribute('src', 'img/456-sad.jpg');
	playerCountBtn.removeAttribute('disabled');
	playerCount.removeAttribute('disabled');
	evenBtn.setAttribute('disabled', 'disabled');
	oddBtn.setAttribute('disabled', 'disabled');
	createBalls(playerCountBalls, compCountBalls);
	stepPlayers(step);
}

//перерасчет шариков и смена картинки мешка
function createBalls(playerCount, compCount) {
	playerCount >= 20 || playerCount <= 0 ?
		playerBag.setAttribute('src', 'img/empty.png') :
		playerBag.setAttribute('src', `img/${playerCount}.png`);

	//compTotal.innerHTML = compCount;
	//playerTotal.innerHTML = playerCount;
}

//ставка и выбор компьютера
function compGuess() {
	//ставка компа случайным образом от 1 до его кол-ва шариков
	guessCompBalls = Math.round(Math.random() * (compCountBalls - 1) + 1);
	//случайный выбор четное или нечетное
	compEvenOdd = Math.round(Math.random());
	console.log('Ставка компа - ' + guessCompBalls);
	if (compEvenOdd) console.log('Комп выбрал нечетное');
	else console.log('Комп выбрал четное');
}


//определение хода игроков
function stepPlayers(step) {
	console.log(step);
	compGuess(); //закадывает комп
	if (step) {  //если ходит игрок
		playText.innerHTML = messages.step_456;
		playerCountBtn.addEventListener('click', function st_pl() {
			guessPlayerBalls = +playerCount.value; //получаем значение из поля
			//проверка на правильность введеного значения
			if (guessPlayerBalls == 0 || guessPlayerBalls > playerCountBalls || isNaN(guessPlayerBalls)) {
				playText.innerHTML = messages.wrong_bet;
				setTimeout(() => {
					playText.innerHTML = messages.step_456;
					playerCount.value = '';
				}, 2000);
			}
			else { //если прошли валидацию
				playerCountBtn.setAttribute('disabled', 'disabled');
				playerCount.setAttribute('disabled', 'disabled');
				evenBtn.removeAttribute('disabled');
				oddBtn.removeAttribute('disabled');
				playerCount.value = '';
				this.removeEventListener('click', st_pl);
			}
		});
	}
	else { //если ходит комп
		playText.innerHTML = messages.step_001;
		evenBtn.setAttribute('disabled', 'disabled');
		oddBtn.setAttribute('disabled', 'disabled');
		playerCountBtn.removeAttribute('disabled');
		playerCount.removeAttribute('disabled');

		playerCountBtn.addEventListener('click', function st_cp() {
			guessPlayerBalls = +playerCount.value; //получаем значение из поля
			//проверка на правильность введеного значения
			if (guessPlayerBalls == 0 || guessPlayerBalls > playerCountBalls || isNaN(guessPlayerBalls)) {
				playText.innerHTML = messages.wrong_bet;
				setTimeout(() => {
					playText.innerHTML = messages.step_456;
					playerCount.value = '';
				}, 2000);
			}
			else { //если прошли валидацию
				writeBets(messages.res_001, guessCompBalls, compEvenOdd);
				checkWinner(guessCompBalls, guessPlayerBalls, compEvenOdd, step);
				playerCount.value = '';
				this.removeEventListener('click', st_cp);
			}
		});
	}
}


//выбор игрока
evenBtn.addEventListener('click', function () {
	checkWinner(guessCompBalls, guessPlayerBalls, 0, step);
	writeBets(messages.res_456, guessPlayerBalls, 0);
});
oddBtn.addEventListener('click', function () {
	checkWinner(guessCompBalls, guessPlayerBalls, 1, step);
	writeBets(messages.res_456, guessPlayerBalls, 1);
});


//запись ставок в таблицу
function writeBets(messBet, countBalls, choices) {
	let item = document.createElement('div');
	item.innerHTML = `${messBet} <strong>${countBalls}</strong> и выбрал ${choices ? 'нечетное' : 'четное'}`;
	results.append(item);
}
//запись результатов хода
function writeResultStep(mess, countBalls) {
	let item = document.createElement('div');
	item.innerHTML = `${mess} <strong>${countBalls}</strong> шт.`;
	results.append(item);
}

//функия отлючения кнопок игрока в случае окончания игры
function disabledButtons() {
	playerCountBtn.setAttribute('disabled', 'disabled');
	playerCount.setAttribute('disabled', 'disabled');
	evenBtn.setAttribute('disabled', 'disabled');
	oddBtn.setAttribute('disabled', 'disabled');
}

//проверка победителя
function checkWinner(valueComp, valuePlayer, check, step) {
	//если ходит игрок и он угадал ставку компа или ходит комп и он не угадал мою ставку
	if ((valueComp % 2 == check && step) || (valuePlayer % 2 != check && !step)) {
		playerCountBalls += valuePlayer; //к своим шарикам прибавляю свою ставку
		compCountBalls -= valuePlayer; //отнимаю у компа свою ставку
		createBalls(playerCountBalls, compCountBalls);
		playerImg.setAttribute('src', 'img/456-happy.jpg');
		compImg.setAttribute('src', 'img/001-sad.jpg');
		//условие окончания игры
		if (playerCountBalls >= 20) {
			playText.innerHTML = messages.win_456;
			playBtn.classList.remove('hide');
			disabledButtons();
			return;
		}
		if (compCountBalls >= 20) {
			playText.innerHTML = messages.win_001;
			playBtn.classList.remove('hide');
			disabledButtons();
			return;
		}
		//сообщение в таблицу о результате
		setTimeout(() => {
			writeResultStep('456 выиграл', valuePlayer);
		}, 500);

	}
	else {
		playerCountBalls -= valueComp; //отнимаю у себя ставку компа
		compCountBalls += valueComp; //прибавляю компу его ставку
		createBalls(playerCountBalls, compCountBalls);
		playerImg.setAttribute('src', 'img/456-sad.jpg');
		compImg.setAttribute('src', 'img/001-happy.jpg');
		//условие окончания игры
		if (playerCountBalls >= 20) {
			playText.innerHTML = messages.win_456;
			playBtn.classList.remove('hide');
			disabledButtons();
			return;
		}
		if (compCountBalls >= 20) {
			playText.innerHTML = messages.win_001;
			playBtn.classList.remove('hide');
			disabledButtons();
			return;
		}
		//сообщение в таблицу о результате
		setTimeout(() => {
			writeResultStep('111 выиграл', valuePlayer);
		}, 500);

	}
	step = !step; //меняю ход
	stepPlayers(step); //запуск нового хода
}
