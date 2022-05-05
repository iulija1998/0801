<?php 
class Person { 
    private $name; 
    private $lastname; 
    private $age; 
    private $hp; 
    private $mother; 
    private $father; 

    function __construct($name, $lastname, $age, $mother = null, $father = null) { 
        $this->name = $name; 
        $this->lastname = $lastname; 
        $this->age = $age; 
        $this->mother = $mother; 
        $this->father = $father; 
        $this->hp = 100; 
    } 
    function sayHi($name) { 
        return "Hi $name, I`m " . $this->name; 
    } 
    function setHp($hp) { 
        if ($this->hp + $hp >= 100)
            $this->hp = 100; 
        else
            $this->hp = $this->hp + $hp; 
    } 
    function getHp() { 
        return $this->hp; 
    } 
    function getName() { 
        return $this->name; 
    } 
    function getLastname() {
        return $this->lastname;
    }
    function getMother() { 
        return $this->mother; 
    } 
    function getFather() { 
        return $this->father; 
    } 
    function getInfo() { 
        return 
        "<h3>A few words about myself:</h3><br>"
        . "My name is: " . $this->getName()
        . "<br> My lastname is: " . $this->getLastname()
        . "<br> My father is: " . $this->getFather()->getName()
        . "<br> My maternal grandfather is: " . $this->getMother()->getFather()->getName()
        . "<br> My maternal grandmother is: " . $this->getMother()->getMother()->getName()
        . "<br> My paternal grandfather is: " . $this->getFather()->getFather()->getName()
        . "<br> My paternal grandmother is: " . $this->getFather()->getMother()->getName()
        . "<br> My mother's maternal grandfather is: " . $this->getMother()->getMother()->getFather()->getName()
        . "<br> My mother's maternal grandfather is: " . $this->getMother()->getMother()->getFather()->getName()
        . "<br> My mother's maternal grandmother is: " . $this->getMother()->getMother()->getMother()->getName()
        . "<br> My mother's paternal grandfather is: " . $this->getMother()->getFather()->getFather()->getName()
        . "<br> My father's paternal grandmother is: " . $this->getFather()->getFather()->getMother()->getName()
        . "<br> My father's maternal grandmother is: " . $this->getFather()->getMother()->getMother()->getName()
        . "<br> My father's paternal grandfather is: " . $this->getFather()->getFather()->getFather()->getName()
        . "<br> My father's paternal grandmother is: " . $this->getFather()->getFather()->getMother()->getName();
    } 
}
$ivan = new Person("Ivan", "Petrov", 93); 
$svetlana = new Person("Svetlana", "Petrova", 90);

$petr = new Person("Petr", "Sidorov", 92);
$elena = new Person("Elena", "Sidorova", 89);

$ruslan = new Person("Ruslan", "Ivanov", 95);
$anastasia = new Person("Anastasia", "Ivanova", 90);

$andrew = new Person("Andrew", "Serov", 94);
$julia = new Person("Julia", "Serova", 88);

$igor = new Person("Igor", "Petrov", 68, $svetlana, $ivan); 
$anna = new Person("Anna", "Petrova", 65, $elena, $petr);

$kirill= new Person("Kirill", "Ivanov", 68, $anastasia, $ruslan);
$inna = new Person("Inna", "Ivanova", 65, $julia, $andrew); 

$alex = new Person("Alex", "Ivanov", 42, $inna, $kirill); 
$olga = new Person("Olga", "Ivanova", 42, $anna, $igor); 

$valera = new Person("Valera", "Ivanov", 15, $olga, $alex); 

echo $valera->getInfo();
// Задача на практическую часть: 
// Создать как минимум 2 бабушки, 2 дедушки по линии каждого из родителей. 
// Вывести на экран информацию о всей родне сына
?>
