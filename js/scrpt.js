$(document).ready(function(){
    $('#searchInputpartainer').on('input change',filterPartenaireUser );

    $('#triPartenerWillaya').on('change', trierParWillaya);
    
    $('#triPartenerCategorie').on('change', triParCategorie);
    $('#action_button').on('click', function (e) {
        e.preventDefault(); 
        executeAction(e);
       
    });
    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault(); 
        console.log("executeAction"); 
        supprimeAction(e); 
    });
    $('#nav-container').on('mouseenter', function () {
        $('nav').addClass('active');
    });
    
    $('nav').on('mouseleave', function () {
        $(this).removeClass('active');
    });
    $('.show-password').on('click', togglePassword);
    $('.show-password').click(togglePassword);

});

function filterPartenaireUser() {
    let searchQuery = $('#searchInputpartainer').val().toLowerCase();

    $('.offre-item').each(function () {
        let partnerName = $(this).find('.partenaire-name').text().toLowerCase();
        let partnerWillaya = $(this).find('.partenaire-willaya').text().toLowerCase();
        let partnerReduction = $(this).find('.partenaire-reduction').text().toLowerCase();

        if (
            partnerName.includes(searchQuery) || 
            partnerWillaya.includes(searchQuery) || 
            partnerReduction.includes(searchQuery)
        ) {
            $(this).show(); 
        } else {
            $(this).hide(); 
        }
    });
}

function triParCategorie() {
    console.log("triParCategorie");
    let categorieOrder = $('#triPartenerCategorie').val(); 

    let categories = $('.partenaire-category').get();

    categories.sort(function (a, b) {
        let categorieA = $(a).find('.category-title').text().toLowerCase();
        let categorieB = $(b).find('.category-title').text().toLowerCase();

        if (categorieOrder === 'ascendante') {
            return categorieA.localeCompare(categorieB);
        } else if (categorieOrder === 'descendante') {
            return categorieB.localeCompare(categorieA);
        }
        return 0;
    });

    $('.partenaire-container').html('');
    $.each(categories, function (index, category) {
        $('.partenaire-container').append(category);
    });
}

function trierParWillaya() {
    console.log("trierParWillaya");
    let willayaOrder = $('#triPartenerWillaya').val();   

    $('.partenaire-category').each(function () {
        let offresItems = $(this).find('.offres-items').children('.offre-item').get();

        offresItems.sort(function (a, b) {
            let willayaA = $(a).find('.partenaire-willaya').text().toLowerCase();
            let willayaB = $(b).find('.partenaire-willaya').text().toLowerCase();

            if (willayaOrder === 'ascendante') {
                return willayaA.localeCompare(willayaB);
            } else if (willayaOrder === 'descendante') {
                return willayaB.localeCompare(willayaA);
            }
            return 0;
        });

        let offresContainer = $(this).find('.offres-items');
        offresContainer.html('');

        $.each(offresItems, function (index, item) {
            offresContainer.append(item);
        });
    });
}


function executeAction(e) {
    console.log("executeAction");

    // Récupérer le bouton cliqué de manière robuste
    const $button = $(e.currentTarget);

    // Récupérer les données associées aux attributs data-*
    const action = $button.data('action');
    const nomClass = $button.data('nomclass');
    const functionName = $button.data('functionname');
    const pathFile = $button.data('pathfile');

    console.log('Données bouton:', action, nomClass, functionName, pathFile);

    // Récupérer les données du formulaire
    const $form = $('form');
    const formData = new FormData($form[0]); // Crée un FormData à partir du formulaire

    // Ajouter les paramètres spécifiques après validation
    if (action) formData.append('action', action);
    if (nomClass) formData.append('nomClass', nomClass);
    if (functionName) formData.append('functionName', functionName);
    if (pathFile) formData.append('pathFile', pathFile);

    console.log('FormData avant l\'envoi :');
    for (let pair of formData.entries()) {
        if (pair[1] instanceof File) {
            if (pair[1].size > 0) {
                console.log(`Fichier sélectionné : ${pair[0]} - Nom: ${pair[1].name}, Taille: ${pair[1].size}, Type: ${pair[1].type}`);
            } else {
                console.log(`Aucun fichier sélectionné pour : ${pair[0]}`);
            }
        } else {
            console.log(`${pair[0]}: ${pair[1]}`);
        }
    }

    // Envoi des données via AJAX
    $.ajax({
        url: '/TDW/actionDashbord', // Vérifiez que cette URL est correcte
        type: 'POST',
        data: formData,
        processData: false, // Ne pas transformer `FormData` en chaîne
        contentType: false, // Permet à `FormData` de gérer automatiquement le type
        success: function (data) {
            console.log('Réponse:', data);
            if (action === 'ajouter') {
                alert('Les données ont été ajoutées avec succès !');
            } else if (action === 'modifier') {
                alert('Les données ont été modifiées avec succès !');
            }

            
            // window.location.href = '../dash';
            //window.location.reload();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error('Erreur:', textStatus, errorThrown);
            alert('Une erreur est survenue lors de l\'envoi des données.');
        }
    });
}



// function executeAction(e) {
//     console.log("executeAction");
//     const $button = $(e.currentTarget);

//     const action = $button.data('action');
//     const nomClass = $button.data('nomclass');
//     const functionName = $button.data('functionname');
//     const pathFile = $button.data('pathfile');
//     const rederection = $button.data('rederection');

//     console.log('Données bouton:', action, nomClass, functionName, pathFile);

//     const $form = $('form');
// if ($form.length === 0) {
//     console.error('Aucun formulaire trouvé.');
//     return;
// }
// const formElement = $form[0];
//     if (!(formElement instanceof HTMLFormElement)) {
//         console.error('L\'élément trouvé n\'est pas un formulaire.');
//         return;
//     }

//     const formData = new FormData(formElement);

//     if (action) formData.append('action', action);
//     if (nomClass) formData.append('nomClass', nomClass);
//     if (functionName) formData.append('functionName', functionName);
//     if (pathFile) formData.append('pathFile', pathFile);

//     console.log('FormData avant l\'envoi :');
//     for (let pair of formData.entries()) {
//         if (pair[1] instanceof File) {
//             if (pair[1].size > 0) {
//                 console.log(`Fichier sélectionné : ${pair[0]} - Nom: ${pair[1].name}, Taille: ${pair[1].size}, Type: ${pair[1].type}`);
//             } else {
//                 console.log(`Aucun fichier sélectionné pour : ${pair[0]}`);
//             }
//         } else {
//             console.log(`${pair[0]}: ${pair[1]}`);
//         }
//     }
//     console.log('FormData avant l\'envoi :', formData);
//     console.log('FormData avant l\'envoi :');
//     for (let [key, value] of formData.entries()) {
//         console.log(`${key}: ${value instanceof File ? value.name : value}`);
//     }
//     $.ajax({
//         url: 'TDW/Controller/DashbordAction.php',
//         type: 'POST',
//         data: { action: 'ajouter', nomClass: 'TestClass', functionName: 'TestFunction' },
//         processData: false, // Empêche jQuery de traiter formData
//         contentType: false, // Empêche jQuery de définir un en-tête Content-Type
//         dataType: 'json',
//         // xhrFields: {
//         //     withCredentials: true // Si vous utilisez des cookies ou des informations d'authentification
//         // },
//         success: function (data) {
//             console.log('Réponse:', data);
//             if (data.status === 'true') {
//                 alert(data.message);
//                 if (rederection) {
//                     window.location.href = rederection;
//                 }
//             } else {
//                 alert(data.message);
//             }
//         },
//         error: function (jqXHR, textStatus, errorThrown) {
//             console.log('Erreur AJAX :', textStatus, errorThrown);
//             alert('Erreur AJAX : ' + textStatus);
//         }
//     });
// }


function supprimeAction(e) {
    console.log("executeAction");

    const $button = $(e.currentTarget);

    const action = $button.data('action');
    const nomClass = $button.data('nomclass');
    const functionName = $button.data('functionname');
    const pathFile = $button.data('pathfile');

    console.log('Données bouton:', action, nomClass, functionName, pathFile);

    const $form = $('form');
    const formData = new FormData($form[0]); 

    if (action) formData.append('action', action);
    if (nomClass) formData.append('nomClass', nomClass);
    if (functionName) formData.append('functionName', functionName);
    if (pathFile) formData.append('pathFile', pathFile);

    console.log('FormData avant l\'envoi :');
    for (let pair of formData.entries()) {
        if (pair[1] instanceof File) {
            if (pair[1].size > 0) {
                console.log(`Fichier sélectionné : ${pair[0]} - Nom: ${pair[1].name}, Taille: ${pair[1].size}, Type: ${pair[1].type}`);
            } else {
                console.log(`Aucun fichier sélectionné pour : ${pair[0]}`);
            }
        } else {
            console.log(`${pair[0]}: ${pair[1]}`);
        }
    }
        if (confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')) {
            const id = $button.data('id');  

            $.ajax({
                url: '/TDW/actionDashbord',  
                type: 'POST',
                data: {
                    action: action,
                    nomClass: nomClass,
                    functionName: functionName,
                    pathFile: pathFile,
                    id: id  
                },
                success: function (data) {
                    console.log('Réponse:', data);
                    if (data.status === 'true') {
                        alert(data.message);
                        $button.closest('tr').remove();  
                    } else {
                        alert(data.message);
                    }
                    
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error('Erreur:', textStatus, errorThrown);
                    alert('Une erreur est survenue lors de la suppression de l\'élément.');
                }
                
            });
        }
   
}

function previewImage(event, attributeId) {
    const input = event.target;
    const preview = document.getElementById('preview-' + attributeId);

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function (e) {
            preview.src = e.target.result; 
            preview.style.display = 'block';
        };

        reader.readAsDataURL(input.files[0]);
    }
}

// function previewImage(event, attributeId) {
//     const input = event.target;
//     const preview = document.getElementById('preview-' + attributeId);

//     if (input.files && input.files[0]) {
//         const reader = new FileReader();

//         reader.onload = function (e) {
//             preview.src = e.target.result; 
//             preview.style.display = 'block';
//         };

//         reader.readAsDataURL(input.files[0]); 
//     }
// }

function showFileName(event, attributeId) {
    const fileNameSpan = document.getElementById('file-name-' + attributeId);

    if (event.target.files && event.target.files[0]) {
        fileNameSpan.textContent = event.target.files[0].name; 
    } else {
        fileNameSpan.textContent = 'Aucun fichier sélectionné';
    }
}

// function previewImage(event, attributeId) {
//     var reader = new FileReader();
//     reader.onload = function () {
//         var imgPreview = document.getElementById('preview-' + attributeId);
//         imgPreview.src = reader.result;
//         imgPreview.style.display = 'block';
//     }
//     reader.readAsDataURL(event.target.files[0]);
// }



function togglePassword() {
    console.log("togglePassword");
    var $passwordField = $('#password');
    var $passwordIcon = $('.show-password i');
    
    if ($passwordField.attr('type') === 'password') {
        $passwordField.attr('type', 'text');
        $passwordIcon.removeClass('fa-eye').addClass('fa-eye-slash');
    } else {
        $passwordField.attr('type', 'password');
        $passwordIcon.removeClass('fa-eye-slash').addClass('fa-eye'); 
    }
}

// Attachez l'événement de clic au span
