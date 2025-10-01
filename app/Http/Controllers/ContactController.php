<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Models\Contact;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Log;

class ContactController extends Controller
{


    use ApiResponses;
    public function index()
{
    $contacts = Contact::orderBy('status', 'asc')
                     ->orderBy('created_at', 'desc')
                     ->get();
    return $this->success('Liste des messages de contact.', $contacts);

}

use ApiResponses;
public function store(StoreContactRequest $request)
{
    $contact = Contact::create([
        'nom' => $request->nom,
        'email' => $request->email,
        'telephone' => $request->telephone,
        'message' => $request->message,
        'status' => false,
    ]);

     return $this->success('Votre message a été envoyé avec succès.', $contact,201);

}

use ApiResponses;
public function show($id)
{
    $contact = Contact::find($id);

    if (!$contact) {
        return $this->error('Message de contact introuvable.', 404);
    }

    return $this->success('Détails du message de contact.', $contact);
}
use ApiResponses;
public function destroy($id)
{
     $contact = Contact::find($id);

    if (!$contact) {
        return $this->error('Message de contact introuvable.', 404);
    }

    $contact->delete();
    return $this->success('Le message a été supprimé avec succès.');

}


use ApiResponses;
public function markAsRead(Contact $contact)
{
    if ($contact->status) {
        return $this->success('Le message est déjà marqué comme lu.');
    }

    $contact->status = true;
    $contact->save();

    return $this->success('Le message a été marqué comme lu.');

}

}
