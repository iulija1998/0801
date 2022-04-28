<?php session_start() ?>
<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous" />
	<title>Личный кабинет</title>
	<style>
		body {
			font-size: 1.5rem;
		}

		.edit-btn {
			color: tomato;
			cursor: pointer;
		}

		.edit-btn:hover {
			color: red;
		}

		.cancel-btn {
			color: cornflowerblue;
			cursor: pointer;
		}

		.cancel-btn:hover {
			color: blue;
		}

		.save-btn {
			color: cornflowerblue;
			cursor: pointer;
		}

		.save-btn:hover {
			color: blue;
		}
	</style>
</head>

<body>
	<!-- <?= $_SESSION['name'] ?> -->


	<div class="container">
		<!-- Строка с именем -->
		<p>Имя: <span><?php echo $_SESSION['name'] ?></span>
			<span class="edit-btn">[Изменить]</span>
			<span class="save-btn" hidden data-item="name">[Сохранить]</span>
			<span class="cancel-btn" hidden>[Отменить]</span>
		</p>
		<!-- Строка с фамилией -->
		<p>Фамилия: <span><?php echo $_SESSION['lastname'] ?></span>
			<span class="edit-btn">[Изменить]</span>
			<span class="save-btn" hidden data-item="lastname">[Сохранить]</span>
			<span class="cancel-btn" hidden>[Отменить]</span>
		</p>


		<p>E-mail: <?php echo $_SESSION['email'] ?></p>
		<p>Id: <?php echo $_SESSION['id'] ?></p>
	</div>

	<script>
		let edit_buttons = document.querySelectorAll(".edit-btn");
		let save_buttons = document.querySelectorAll(".save-btn");
		let cancel_buttons = document.querySelectorAll(".cancel-btn");

		for (let i = 0; i < edit_buttons.length; i++) {
			//Работаю с кнопкой edit
			let inputValue = edit_buttons[i].previousElementSibling.innerText; /* Сохраняю значение инпута, полученное из сессии */

			edit_buttons[i].addEventListener("click", function() {
				edit_buttons[i].previousElementSibling.innerHTML = `<input type="text" value = "${inputValue}">`; /* Стань инпутом и внутрь кладу значение, полученное  в переменную  inputValue*/
				save_buttons[i].hidden = false;
				cancel_buttons[i].hidden = false;
				edit_buttons[i].hidden = true;

			});
			//Работаю с кнопкой save
			save_buttons[i].addEventListener("click", async () => {
				let newInputValue = edit_buttons[i].previousElementSibling.firstElementChild.value;
				edit_buttons[i].previousElementSibling.innerText = newInputValue;
				save_buttons[i].hidden = true;
				cancel_buttons[i].hidden = true;
				edit_buttons[i].hidden = false;

				let FormData = new FormData();
				FormData.append("value", newInputValue);
				FormData.append("item", save_buttons[i].dataset.item);

				let response = await fetch("php/lk_obr.php", {
					method: "POST",
					body: FormData,
				})
			})

			//Работаю с кнопкой cancel
			cancel_buttons[i].addEventListener("click", function() {
				edit_buttons[i].previousElementSibling.innerText = inputValue;
				save_buttons[i].hidden = true;
				cancel_buttons[i].hidden = true;
				edit_buttons[i].hidden = false;
			})

		}
	</script>
	<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
</body>

</html>
