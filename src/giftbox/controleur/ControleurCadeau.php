<?php

namespace giftbox\controleur;

use giftbox\vue\VueCadeau;
use Illuminate\Database\Capsule\Manager as DB;
use giftbox\models as models;

class ControleurCadeau
{
    public function __construct(){

        $db = new DB();

        //Chargement du fichier de configuration
        $config=parse_ini_file('src/conf/db.ini');

        //Création de la connexion à la base de données
        $db->addConnection( [
            'driver' => $config['driver'],
            'host' => $config['host'],
            'database' => $config['database'],
            'username' => $config['username'],
            'password' => $config['password'],
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => ''
        ] );
        $db->setAsGlobal();
        $db->bootEloquent();
    }

    public function showGift($url){

        $cadeau = models\Coffret::where('urlCadeau', '=', $url)->first();

        if($cadeau == null){

            $_SESSION['message']['type'] = "negative";
            $_SESSION['message']['content'] = "L'URL renseignée ne correspond à aucun cadeau !";
            $_SESSION['message']['header'] = "Erreur !";
            return false;
        } else {

            $data['url'] = $url;
            $data['coffret'] = $cadeau;
            $data['prestation'] = array();
            if(!isset($_SESSION['gift'][$url])){

                $_SESSION['gift'][$url] = 0;
                $data['prestation'][] = [models\Prestation::where('id', '=', $cadeau->prestations[0]->id_prestation)->first(), $cadeau->prestations[0]->nb_prestation];
            } else {

                $countPrestation = count($cadeau->prestations);
                if($_SESSION['gift'][$url] < $countPrestation - 1){

                    $_SESSION['gift'][$url]++;
                    $data['prestation'][] = [models\Prestation::where('id', '=', $cadeau->prestations[$_SESSION['gift'][$url]]->id_prestation)->first(), $cadeau->prestations[0]->nb_prestation];
                } else {

                    foreach ($cadeau->prestations as $prestation){

                        array_push($data['prestation'], [models\Prestation::where('id', '=', $prestation->id_prestation)->first(), $prestation->nb_prestation]);
                    }
                    $data['finish'] = true;
                }
            }



            if(!$cadeau->cagnotte->isEmpty()){
                $data['contributions'] = $cadeau->cagnotte->first()->contributions;
            }

            $vue = new VueCadeau($data);
            return $vue->render("SHOW_GIFT");
        }
    }

    public function deleteGift($url, $mail){

        $cadeau = models\Coffret::where('urlCadeau', '=', $url)->first();

        if($cadeau == null){

            $_SESSION['message']['type'] = "negative";
            $_SESSION['message']['content'] = "L'URL renseignée ne correspond à aucun cadeau !";
            $_SESSION['message']['header'] = "Erreur !";
            return false;
        } else {

            $cadeau->urlCadeau = "";
            $cadeau->save();

            if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
            {
                $passage_ligne = "\r\n";
            }
            else
            {
                $passage_ligne = "\n";
            }
            //=====Déclaration des messages au format texte et au format HTML.
                        $message_txt = "Voici votre coffret : ";
                        $message_html = "<html><head></head><body><b>Voici votre coffret</b><ul>";

                        foreach ($cadeau->prestations as $prestation){

                            $message_txt .= models\Prestation::where('id', '=', $prestation->id_prestation)->first()->nom;
                            $message_txt .= "x" . $prestation->nb_prestation . " ";

                            $message_html .= "<li>" . models\Prestation::where('id', '=', $prestation->id_prestation)->first()->nom . "</li>";
                        }

                        $message_html .= "</ul></body></html>";
            //==========

            //=====Création de la boundary
                        $boundary = "-----=".md5(rand());
            //==========

            //=====Définition du sujet.
                        $sujet = "Giftbox -- Recu du coffret";
            //=========

            //=====Création du header de l'e-mail.
                        $header = "From: \"Giftbox\"<giftbox@voxystudio.com>".$passage_ligne;
                        $header.= "Reply-to: \"Giftbox\" <giftbox@voxystudio.com>".$passage_ligne;
                        $header.= "MIME-Version: 1.0".$passage_ligne;
                        $header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
            //==========

            //=====Création du message.
                        $message = $passage_ligne."--".$boundary.$passage_ligne;
            //=====Ajout du message au format texte.
                        $message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$passage_ligne;
                        $message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
                        $message.= $passage_ligne.$message_txt.$passage_ligne;
            //==========
                        $message.= $passage_ligne."--".$boundary.$passage_ligne;
            //=====Ajout du message au format HTML
                        $message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$passage_ligne;
                        $message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
                        $message.= $passage_ligne.$message_html.$passage_ligne;
            //==========
                        $message.= $passage_ligne."--".$boundary."--".$passage_ligne;
                        $message.= $passage_ligne."--".$boundary."--".$passage_ligne;
            //==========

            //=====Envoi de l'e-mail.
                        mail($mail,$sujet,$message,$header);
            //==========

            $_SESSION['message']['type'] = "positive";
            $_SESSION['message']['content'] = "Un mail a été envoyé à : " . $mail . ", si vous ne le trouvez pas, vérifiez vos spam !";
            $_SESSION['message']['header'] = "Succès !";
        }
    }

}