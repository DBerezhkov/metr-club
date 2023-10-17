//Полифилл для метода forEach для NodeList
if(window.NodeList && !NodeList.prototype.forEach){
NodeList.prototype.forEach = function(callback, thisArg){
    thisArg = thisArg || window
    for(var i = 0; 0 < this.length; i++){
        callback.call(thisArg, this[i], i, this)
    }
}
}

const dropDownBtn = document.querySelector('.dropdown__button')
const dropDownList = document.querySelector('.dropdown__list')
const dropDownListItems = dropDownList.querySelectorAll('.dropdown__list-item')
const dropDownInput = document.querySelector('.dropdown__input-hidden')


// клик по кнопке открыть/закрыть select

dropDownBtn.addEventListener('click', function(){
dropDownList.classList.toggle('dropdown__list--visible')
})


// выбор элемента списка. Запомнить выбранное значение, закрыть дропдаун
dropDownListItems.forEach(function(listItem){
    listItem.addEventListener('click', function(e){
        e.stopPropagation()
        dropDownBtn.innerText = this.innerText
        dropDownBtn.style.color = 'black'
        dropDownBtn.style.fontWeight = "500"
        dropDownInput.value = this.dataset.value;

        dropDownList.classList.remove('dropdown__list--visible') 
    })
})

//клик снаружи дропдауна. закрыть дропдаун

document.addEventListener('click', function(e){
if(e.target !== dropDownBtn){
    dropDownList.classList.remove('dropdown__list--visible')
}
})

//при нажатии на tab или escape закрыть дропдаун
document.addEventListener('keydown', function(e){
if(e.key === 'Tab' || e.key === 'Escape') {
    dropDownList.classList.remove('dropdown__list--visible')
}
})