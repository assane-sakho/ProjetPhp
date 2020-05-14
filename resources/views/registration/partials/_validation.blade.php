<br />
@if(!session('isRegistrationComplete'))
<h5>Validation du dossier</h5>
@else
<h5>Récapitulatif du dossier</h5>
@endif
<div id="form-step-5" role="form" data-toggle="validator">
    <div class="form-group col-md-10">
        <table class="table table-bordered">
            <tr>
                <th>Statut de la candidature</th>
                <td class="text-info">{{ session('student')->registration->registration_status->title}}</td>
            </tr>
            <tr rowspan="2">
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <th>Nom</th>
                <td>{{ session('student')->lastname }} </td>
            </tr>
            <tr>
                <th>Prénom</th>
                <td>{{ session('student')->firstname }} </td>
            </tr>
            <tr>
                <th>N° de carte d'identité</th>
                <td>{{ session('student')->card_id }} </td>
            </tr>
            <tr>
                <th>Date de naissance</th>
                <td>{{ session('student')->birthdate->format('d/m/Y') }} </td>
            </tr>
            <tr>
                <th>Adresse mail</th>
                <td>{{ session('student')->email }} </td>
            <tr>
                <th>Téléphone</th>
                <td>{{ session('student')->phone_number }} </td>
            </tr>
            <tr>
                <th>Adresse</th>
                <td>{{ session('student')->address->street }}, {{ session('student')->address->zip_code }} {{ session('student')->address->city }} </td>
            </tr>
            <tr rowspan="2">
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <th>Filière choisis</th>
                <td>{{ session('student')->registration->training->name }}</td>
            </tr>
            <tr>
                <th>Pour la formation classique</th>
                <td>{{ session('student')->registration->classicTraining == '1' ? 'Oui' : 'Non' }}</td>
            </tr>
            <tr>
                <th>Pour la formation par apprentissage</th>
                <td>{{ session('student')->registration->apprenticeshipTraining == '1' ? 'Oui' : 'Non' }}</td>
            </tr>
            <tr rowspan="2">
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <th>CV</th>
                <td><embed src="/Registration/GetFile?fileName=cv" style="width:150px; height:200px;" frameborder="0">
                <a href="#" onclick="displayFile('/Registration/GetFile?fileName=cv', true)"><i class="fas fa-external-link-alt"></i></a></td>
            </tr>
            <tr>
                <th>Lettre de motivation</th>
                <td><embed src="/Registration/GetFile?fileName=cover_letter" style="width:150px; height:200px;" frameborder="0">
                <a href="#" onclick="displayFile('/Registration/GetFile?fileName=cover_letter', true)"><i class="fas fa-external-link-alt"></i></a></td>
            </tr>
            <tr>
                <th>Relevés de notes de l’année précédente</th>
                <td>
                    @for ($i = 0; $i < count(session('student')->registration->folder->report_cards); $i++)
                        <embed src="/Registration/GetFile?fileName=report_card&number={{$i}}" style="width:150px; height:200px;" frameborder="0">
                        <a href="#" onclick="displayFile('/Registration/GetFile?fileName=report_card&number={{$i}}', true)"><i class="fas fa-external-link-alt"></i></a>
                     @endfor
                </td>
            </tr>
            <tr>
                <th>Imprime écran de l’ENT de l’année en cours</th>
                <td><img class="img-fluid" src="/Registration/GetFile?fileName=vle_screenshot" alt="">
                <a href="#" onclick="displayFile('/Registration/GetFile?fileName=vle_screenshot', false)"><i class="fas fa-external-link-alt"></i></a></td>
            </tr>
            <tr>
                <th>Formulaire d'inscription</th>
                <td><embed src="/Registration/GetFile?fileName=registration_form" style="width:150px; height:200px;" frameborder="0">
                <a href="#" onclick="displayFile('/Registration/GetFile?fileName=registration_form', true)"><i class="fas fa-external-link-alt"></i></a></td>
            </tr>
        </table>
        <div class="help-block with-errors"></div>
    </div>
</div>