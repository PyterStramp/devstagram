import Dropzone from "dropzone";

//dropzone buscar un elemento de clase dropzone, pero esto es para que no sea automático
Dropzone.autoDiscover = false;

const dropzone = new Dropzone('#dropzone', {
    dictDefaultMessage: 'Sube tu imagen',
    acceptedFiles: '.png,.jpg,.jpeg,.gif,.webp',
    addRemoveLinks: true,
    dictRemoveFile: 'Borrar archivo',
    maxFiles: 1,
    uploadMultiple: false,

    init: function () {
        if(document.querySelector('[name="imagen"]').value.trim()){
            const fileName = document.querySelector('[name="imagen"]').value.trim()
            const file = {name: fileName, size: 1234, url:`/uploads/${fileName}`};  
               
            let mockfile = {
                name: file.name,
                size: file.size,
            };
    
            this.displayExistingFile(mockfile, file.url);
        }        
    }
});

dropzone.on('success', (file, response)=> {
    document.querySelector('[name="imagen"]').value = response.img;
});

dropzone.on('removedfile', () => {
    document.querySelector('[name="imagen"]').value = "";
});
