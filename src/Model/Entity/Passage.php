<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Passage Entity
 *
 * @property int $id
 * @property string $name
 * @property \Cake\I18n\Time $date_passage
 * @property string $lieux
 * @property string $description
 * @property int $archive
 * @property \Cake\I18n\Time $date_desactivation
 * @property string $document
 * @property int $discipline_id
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property int $evenement_id
 *
 * @property \App\Model\Entity\Discipline $discipline
 * @property \App\Model\Entity\Evenement $evenement
 * @property \App\Model\Entity\InscriptionPassage[] $inscription_passages
 */
class Passage extends Entity
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
