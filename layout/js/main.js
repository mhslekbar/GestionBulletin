$(document).ready(function(){
    
    'use strict';
    

    $(".msg").slideDown(300,function(){
        $(this).append("<strong class='float-end'>x</strong>");
        $("strong").css("cursor","pointer");
    });
    $(".msg").on("click","strong",function(){
        $(this).closest(".msg").slideUp();
    });

    /* Start Manage Student  */

    $(".btnEdit").on("click",function(){
        var data = $(this).closest("tr").children("td").map(function(){
            return $(this).text();
        }).get();
        $("#regNo").val(data[1]);
        $("#fname").val(data[2]);
        $("#phone").val(data[3]);
        $("#addr").val(data[4]);
        $("#classe").val(data[6]);

    });


    // delete student 

    $(document).on("click",".btnDelete",function(){
        $("#mat").val($(this).data("delete"))
    });

    $("#classeEtudiant").on("change",function(){
        var idClasse = $(this).val();
        if(idClasse !=""){
            $.ajax({
                url: "noteCode/getStudentsAndDisplayOnTable.php",
                method: "POST",
                data : {"idClasse" : idClasse},
                success : function(response){
                     $(".table-student").empty();
                     if(response !=""){
                        $(".table-student").append('<thead>\
                                <tr>\
                                    <th scope="col">#ID</th>\
                                    <th scope="col">Register No</th>\
                                    <th scope="col">FullName</th>\
                                    <th scope="col">Telephone</th>\
                                    <th scope="col">Address</th>\
                                    <th scope="col">Control</th>\
                                </tr>\
                            </thead>\
                            <tbody>\
                        ');
                        $.each(response,function(key,value){
                            // alert(value['FullName']);
                            $(".table-student").append('<tr>\
                                                        <td scope="row"> '+value['id']+'</td>\
                                                        <td> '+value['Matricule']+' </td>\
                                                        <td> '+value['FullName']+' </td>\
                                                        <td> '+value['Telephone']+' </td>\
                                                        <td> '+value['Addresse']+' </td>\
                                                        <td class="control">\
                                                            <button type="button" class="btn btn-success btnEdit" data-edit="'+value['id']+'" data-bs-toggle="modal" data-bs-target="#editModal">\
                                                                <i class="fas fa-edit"></i> Edit\
                                                            </button>\
                                                            <button type="button" class="btn btn-danger btnDelete" data-delete="'+value['id']+'" data-bs-toggle="modal" data-bs-target="#deleteModal">\
                                                                <i class="fas fa-user-times"></i> Delete\
                                                            </button>' +                        
                                                            '</td>\
                                                        </tr>\
                                                    ');
                        });
                        $(".table-student").append("</tbody>'");

                     } // end check if response Not equal null
                } // end success brackets
             });
        } else {
            $(".table-student").empty();
        } // end if idCLasse equal not null
    });


    /* End Manage Student  */


    /* Start Manage Classes  */

    $(document).on("click",".remove-btn",function(){
        $(this).closest(".new-matiere").slideUp(300,function(){
            $(this).remove();
        });
    });


    $(document).on("click","#add-new-matiere",function(){
        
        if($(".new-matiere:last-child #new-mat").val() !=""){

            getMatiere();
    
            $(".main-matiere").append('<div class="form-group new-matiere mt-2 p-arrow">\
                                            <div class="row">\
                                                <div class="col-md-9">\
                                                <select name="matieres[]" id="new-mat" class="form-control ajouter-mat">\
                                                </select>\
                                                <i class="fas fa-angle-down angle-new"></i>\
                                                 </div>\
                                                <div class="col-md-2">\
                                                    <button type="button" class="btn btn-danger remove-btn">Supprimer</button>\
                                                </div>\
                                            </div>\
                                        </div>\
                                        ');
    
        }
        
    });
    
    function getMatiere(){
        
        $.ajax({
            url: "getMatieres.php",
            method: "GET",
            success: function(response){
                $("<option value=''>choisir une matiere</option>").appendTo(".new-matiere:last-child .ajouter-mat");
                $.each(response,function(key,value){
                    $('<option value="'+value['idMatiere']+'">'+value['NomMatiere']+'</option>').appendTo(".new-matiere:last-child .ajouter-mat");
                });    
            },
            error: function(err,r,t) {
                alert(err + r + t);
            }
        });
    
    }

    $(document).on("change",".classes #selectClasse",function(){
        var idClasse = $(this).val();
        $(".classes .table").addClass("d-none");
        $(".classes .afficherMatiereInClasseFile").empty();
        if(idClasse !="") {
            $.ajax({
                url: "noteCode/afficherMatiereOnTable.php",
                method: "GET",
                data: {"idClasse" : idClasse},
                success: function(response){
                    $.each(response,function(key,value){
                        $(".classes .table").removeClass("d-none");
                        $(".classes .afficherMatiereInClasseFile").append("<tr>\
                                    <td>"+value['id']+"</td>\
                                    <td>"+value['NomMatiere']+"</td>\
                                    <td><button class='btn btn-danger custom-delete-btn' data-subject='"+value['idClasse']+"'  data-bs-toggle='modal' data-bs-target='#deleteModal'>supprimer</button></td>\
                            </tr>");
                    });
                },
            });
        }
    });

    $(document).on("click",".classes .custom-delete-btn",function(){
        var idClasse = $(this).data("subject");
        $("#deleteIdClasse").val(idClasse);
    })

    /* End Manage Classes  */
    
    
    
    /* Start Manage Classes  */

    $(".notes #classe").on("change",function(){
        var idClasse = $(".notes #classe").val();
        var idmat = $(".notes #subject").val();
        
        $(".table-note").addClass("d-none");
        $(".afficherMatIntoNote").addClass("d-none");
        $(".notes #subject").empty();

        if(idClasse !="" || idmat !=""){
            $.ajax({
                url: "noteCode/setMatiereToNote.php",
                method: "GET",
                data: {"idClasse" : idClasse},
                success: function(res){
                    $('<option value="">Choisir la matiere</option>').appendTo(".notes #subject");
                    $.each(res,function(key,value){
                        $(".afficherMatIntoNote").removeClass("d-none");                
                        $("<option value='"+value['idMatiere']+"'>"+value['NomMatiere']+"</option>").appendTo(".notes #subject");
                    });
                },
            });
        } else {
            $(".table-note").addClass("d-none");
        }// End if 
    });

    $(".notes #subject").on("change",function(){
        var idmat = $(this).val();
        var idclass = $(".notes #classe").val();
        // alert(idmat);
        $(".table-note").addClass("d-none");
        if(idmat !="" || idclass !=""){
            $(".assignNotes").empty();
                $.ajax({
                url: "noteCode/getAllStudentAndNotes.php",
                method: "GET",
                data: {"idMatiere" : idmat , "idClasse" : idclass},
                success: function(result){
                    // $(".assignNotes").empty();
                    $.each(result,function(key,value){
                        $(".table-note").removeClass("d-none");
                        $(".assignNotes").append('<tr>\
                                                    <th><input type="text" class="inp-matricule" readonly name="matricule[]" value="'+value['Matricule']+'"></th>\
                                                    <td>'+value['FullName']+'</td>\
                                                    <td><input type="number" step=".01" readonly name="devoir[]" id="devoir" value="'+value['NoteDevoir']+'"></td>\
                                                    <td><input type="number" step=".01" readonly name="compo[]" id="compo" value="'+value['NoteCompo']+'"></td>\
                                                </tr>');
                    });
                },
                error: function (err){
                    alert(err);
                }
                
            });
        }

    });

    // fa-edit note

    $(document).on("click",".custom-edit-note",function(){  
        $(".table-note #devoir ,.table-note #compo ").removeAttr("readonly");
        $(".table-note #devoir , .table-note #compo ").css("background-color","#EEE");
        $(".table-note #devoir , .table-note #compo ").addClass("form-control");
    });

    $(document).on("dblclick",".custom-edit-note",function(){  
        $(".table-note #devoir ,.table-note #compo ").attr("readonly",true);
        $(".table-note #devoir , .table-note #compo ").css({"background-color":"#FFF","padding" :"10px"});
        $(".table-note #devoir , .table-note #compo ").removeClass("form-control"); 
    });


    /* End Manage Notes  */

    /*  DashBoard */
    $(document).on("keyup",".dashboard #matriculeCheck",function(){
        var matricule = $(this).val();
        $(".bulletin").empty();
        $(".infoBulletin").empty();
        if(matricule != ""){

            $.ajax({
                url: 'noteCode/checkMatricule.php',
                method: 'GET',
                data: {'regNo' : matricule},
                type: "JSON",
                success: function(response){
                    var sumMGM = 0 , sumCoeff = 0 ,count = 0; 
                    if(response != ""){
                        $(".table-bulletin").removeClass("d-none");
                        $.each(response,function(key,value){
                            $(".displayErrorCheck").hide();
                            if(count == 0){
                                $(".infoBulletin").append('<label> Nom Et Prenom : '+value['FullName']+'</label><br>\
                                    <label>Matricule : '+value['Matricule']+'</label><br>\
                                    <label>Classe : '+value['NomClasse']+'</label>\
                                ');
                            }
                            $(".bulletin").append('<tr>\
                                <td>INI-'+value['Matiere']+'</td>\
                                <td>'+value['NomMatiere']+'</td>\
                                <td>'+value['Coeff']+'</td>\
                                <td>'+value['NoteDevoir']+'</td>\
                                <td>'+value['NoteCompo']+'</td>\
                                <td>'+ (((value['NoteDevoir'] * 0.4) + (value['NoteCompo'] * 0.6)) * value['Coeff']).toFixed(2) +'</td>\
                            </tr>');
                            sumMGM += (((value['NoteDevoir'] * 0.4) + (value['NoteCompo'] * 0.6)) * value['Coeff']);
                            sumCoeff += parseInt(value['Coeff']);
                            count++;
                        });
                        $(".bulletin").append('<tr>\
                                <td colspan="5"><strong>Moyenne Generale</strong></td>\
                                <td><strong id="MGM">'+(sumMGM / sumCoeff).toFixed(2)+'</strong></td>\
                        </tr>');
                        if(((sumMGM / sumCoeff).toFixed(2)) >= 9 ){
                            $(".bulletin").append("<strong id='decisionGood'>decision : Admis</strong>");
                        }else {
                            $(".bulletin").append("<strong id='decisionBad'>decision : Ajourné</strong>");
                        }
                        $("#decisionGood span").empty();
                        $("#decisionBad span").empty();
                        $.ajax({
                            url: "noteCode/getRankOfStudent.php",
                            method: "POST",
                            data: {"regNo" : matricule},
                            success: function(res) {
                                $("#decisionGood").after("<span> Rang : " + res + "</span>");
                                $("#decisionBad").after("<span> Rang : " + res + "</span>");
                            },
                            error: function(err) {
                                alert(err);
                            }
                        });
                        
                    }else {
                        $(".table-bulletin").addClass("d-none");  
                        $(".displayErrorCheck").fadeIn(500);
                        $(".displayErrorCheck").text("Matricule N'existe pas ");
                    }
                },
            });    
            
        } else {
            $(".displayErrorCheck").fadeOut(500);
            $(".table-bulletin").addClass("d-none");
        }

    });

});