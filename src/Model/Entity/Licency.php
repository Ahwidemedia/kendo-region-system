<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Licency Entity
 *
 * @property int $id
 * @property string $nom
 * @property string $prenom
 * @property string $ddn
 * @property \Cake\I18n\Time $date_naissance
 * @property string $lieu_naissance
 * @property string $adresse
 * @property string $sexe
 * @property string $numero_licence
 * @property string $nationalite
 * @property string $telephone
 * @property string $fax
 * @property string $email
 * @property int $club_id
 * @property int $grade_actuel_id
 * @property string $grade_actuel_lieux
 * @property string $grade_actuel_organisation
 * @property \Cake\I18n\Time $grade_actuel_date
 * @property int $discipline_id
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Club $club
 * @property \App\Model\Entity\GradeActuel $grade_actuel
 * @property \App\Model\Entity\Discipline $discipline
 */
class Licency extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
