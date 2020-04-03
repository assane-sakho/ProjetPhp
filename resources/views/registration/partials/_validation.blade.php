<br />
<h5>Validation du dossier</h5>
<div id="form-step-5" role="form" data-toggle="validator">
    <div class="form-group col-md-10">
        <table class="table table-bordered">
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
                <td id="td-training"> </td>
            </tr>
            <tr rowspan="2">
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <th>CV</th>
                <td id="td-cv"> </td>
            </tr>
            <tr>
                <th>Lettre de motivation</th>
                <td id="td-coverLetter"></td>
            </tr>
            <tr>
                <th>Relevés de notes de l’année précédente</th>
                <td id="td-reportCard"></td>
            </tr>
            <tr>
                <th>Imprime écran de l’ENT de l’année en cours</th>
                <td id="td-vleScreenshot"></td>
            </tr>
        </table>
        <div class="help-block with-errors"></div>
    </div>
</div>