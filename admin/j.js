const showBtn=document.querySelector('.action-btn');
const modalOverlay=document.querySelector('.modal-overlay');
const closeBtn=document.querySelector('.close-modal');

showBtn.addEventListener('click',()=>{
    modalOverlay.classList.add('show');
});

closeBtn.addEventListener('click',()=>{
    modalOverlay.classList.remove('show');
});

modalOverlay.addEventListener('click',(e)=>{
    if(e,target===modalOverlay){
        modalOverlay.classList.remove('show');
    }
});

document.addEventListener('keydown',(e)=>{
    if(e,key==='Escape'){
        modalOverlay.classList.remove('show');
    }
});