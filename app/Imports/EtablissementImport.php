use Maatwebsite\Excel\Facades\Excel;
use App\Imports\EtablissementImport;

Route::get('/import-excel', function () {
    Excel::import(new EtablissementImport, 'storage/app/etablissements.xlsx');
});
