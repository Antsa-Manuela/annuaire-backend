use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ContactsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Contact([
            'nom'       => $row['nom'],
            'email'     => $row['email'],
            'telephone' => $row['telephone'] ?? null,
        ]);
    }
}
