<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Task;

class ReleaseSeed extends Migration
{
    private $materials = [
        //============================= Ores
        ['id' => 1, 'name' => 'Copper', 'base_value' => 3],
        ['id' => 2, 'name' => 'Coal', 'base_value' => 3],
        ['id' => 3, 'name' => 'Iron', 'base_value' => 10],
        ['id' => 4, 'name' => 'Orichalcum', 'base_value' => 10],
        ['id' => 5, 'name' => 'Mithril', 'base_value' => 10],
        ['id' => 6, 'name' => 'Podirian', 'base_value' => 10],
        ['id' => 7, 'name' => 'Sapphire', 'base_value' => 10],
        ['id' => 8, 'name' => 'Emerald', 'base_value' => 10],
        ['id' => 9, 'name' => 'Ruby', 'base_value' => 10],
        ['id' => 10, 'name' => 'Amethyst', 'base_value' => 10],
        ['id' => 11, 'name' => 'Diamond', 'base_value' => 10],
        ['id' => 12, 'name' => 'Platinum', 'base_value' => 10],
        //============================= Hides / Scales
        ['id' => 13, 'name' => 'Hide', 'base_value' => 10],
        ['id' => 14, 'name' => 'Leather', 'base_value' => 10],
        ['id' => 15, 'name' => 'Lizard skin', 'base_value' => 10],
        ['id' => 16, 'name' => 'Naga hide', 'base_value' => 10],
        ['id' => 17, 'name' => 'Daemon skin', 'base_value' => 10],
        ['id' => 18, 'name' => 'Dragon hide', 'base_value' => 10],
        ['id' => 19, 'name' => 'Dragon scale', 'base_value' => 10],
        //============================= Fabric
        ['id' => 20, 'name' => 'Cotton fabric', 'base_value' => 10],
        ['id' => 21, 'name' => 'Linen fabric', 'base_value' => 10],
        ['id' => 22, 'name' => 'Wool fabric', 'base_value' => 10],
        ['id' => 23, 'name' => 'Silk fabric', 'base_value' => 10],
        ['id' => 24, 'name' => 'Arcane fabric', 'base_value' => 10],
        ['id' => 25, 'name' => 'Dragon silk fabric', 'base_value' => 10],
        //============================= Biology
        ['id' => 26, 'name' => 'Goldbloom', 'base_value' => 10],
        ['id' => 27, 'name' => 'Silverroot', 'base_value' => 10],
        ['id' => 28, 'name' => 'Mindsage', 'base_value' => 10],
        ['id' => 29, 'name' => 'Eaflari', 'base_value' => 10],
        ['id' => 30, 'name' => 'Scourgemoss', 'base_value' => 10],
        ['id' => 31, 'name' => 'Yeti tooth', 'base_value' => 10],
        ['id' => 32, 'name' => 'Harpy claw', 'base_value' => 10],
        ['id' => 33, 'name' => 'Cockatrice tear', 'base_value' => 10],
        ['id' => 34, 'name' => 'Hydra bone', 'base_value' => 10],
        ['id' => 35, 'name' => 'Chimera mane', 'base_value' => 10],
        ['id' => 36, 'name' => 'Pheonixflower', 'base_value' => 10],
    ];

    private $items = [
        ['id' => 1, 'name' => 'Copper Sword', 'base_value' => 50]
    ];

    private $tasks = [
        //============================== Mines
        [
            'id' => 1,
            'name' => 'Copper Mine',
            'type' => Task::TYPE_GATHER,
            'sub_type' => Task::GATHER_TYPE_MINING,
            'base_time' => 20,
            'gold_cost' => 500,
            'gems_cost' => 0,
            'experience_reward' => 10
        ],
        [
            'id' => 2,
            'name' => 'Coal Mine',
            'type' => Task::TYPE_GATHER,
            'sub_type' => Task::GATHER_TYPE_MINING,
            'base_time' => 60,
            'gold_cost' => 10000,
            'gems_cost' => 0,
            'experience_reward' => 20
        ],
        [
            'id' => 3,
            'name' => 'Iron Mine',
            'type' => Task::TYPE_GATHER,
            'sub_type' => Task::GATHER_TYPE_MINING,
            'base_time' => 60,
            'gold_cost' => 10000,
            'gems_cost' => 0,
            'experience_reward' => 20
        ],

        [
            'id' => 4,
            'name' => 'Orichalcum Mine',
            'type' => Task::TYPE_GATHER,
            'sub_type' => Task::GATHER_TYPE_MINING,
            'base_time' => 60,
            'gold_cost' => 10000,
            'gems_cost' => 0,
            'experience_reward' => 20
        ],
        [
            'id' => 5,
            'name' => 'Mithril Mine',
            'type' => Task::TYPE_GATHER,
            'sub_type' => Task::GATHER_TYPE_MINING,
            'base_time' => 60,
            'gold_cost' => 10000,
            'gems_cost' => 0,
            'experience_reward' => 20
        ],
        [
            'id' => 6,
            'name' => 'Podirian Mine',
            'type' => Task::TYPE_GATHER,
            'sub_type' => Task::GATHER_TYPE_MINING,
            'base_time' => 60,
            'gold_cost' => 10000,
            'gems_cost' => 0,
            'experience_reward' => 20
        ],
        [
            'id' => 7,
            'name' => 'Gemstone Mine',
            'type' => Task::TYPE_GATHER,
            'sub_type' => Task::GATHER_TYPE_MINING,
            'base_time' => 60,
            'gold_cost' => 10000,
            'gems_cost' => 0,
            'experience_reward' => 20
        ],
        [
            'id' => 8,
            'name' => 'Platinum Mine',
            'type' => Task::TYPE_GATHER,
            'sub_type' => Task::GATHER_TYPE_MINING,
            'base_time' => 60,
            'gold_cost' => 10000,
            'gems_cost' => 0,
            'experience_reward' => 20
        ],
        //============================== Tanneries
        [
            'id' => 9,
            'name' => 'Hide Tannery',
            'type' => Task::TYPE_GATHER,
            'sub_type' => Task::GATHER_TYPE_TANNING,
            'base_time' => 60,
            'gold_cost' => 10000,
            'gems_cost' => 0,
            'experience_reward' => 20
        ],
        [
            'id' => 10,
            'name' => 'Leather Tannery',
            'type' => Task::TYPE_GATHER,
            'sub_type' => Task::GATHER_TYPE_TANNING,
            'base_time' => 60,
            'gold_cost' => 10000,
            'gems_cost' => 0,
            'experience_reward' => 20
        ],
        [
            'id' => 11,
            'name' => 'Lizard skin Tannery',
            'type' => Task::TYPE_GATHER,
            'sub_type' => Task::GATHER_TYPE_TANNING,
            'base_time' => 60,
            'gold_cost' => 10000,
            'gems_cost' => 0,
            'experience_reward' => 20
        ],
        [
            'id' => 12,
            'name' => 'Naga hide Tannery',
            'type' => Task::TYPE_GATHER,
            'sub_type' => Task::GATHER_TYPE_TANNING,
            'base_time' => 60,
            'gold_cost' => 10000,
            'gems_cost' => 0,
            'experience_reward' => 20
        ],
        [
            'id' => 13,
            'name' => 'Daemon skin Tannery',
            'type' => Task::TYPE_GATHER,
            'sub_type' => Task::GATHER_TYPE_TANNING,
            'base_time' => 60,
            'gold_cost' => 10000,
            'gems_cost' => 0,
            'experience_reward' => 20
        ],
        [
            'id' => 14,
            'name' => 'Dragon hide Tannery',
            'type' => Task::TYPE_GATHER,
            'sub_type' => Task::GATHER_TYPE_TANNING,
            'base_time' => 60,
            'gold_cost' => 10000,
            'gems_cost' => 0,
            'experience_reward' => 20
        ],
        //============================== Weaving
        [
            'id' => 15,
            'name' => 'Cotton Loom',
            'type' => Task::TYPE_GATHER,
            'sub_type' => Task::GATHER_TYPE_WEAVING,
            'base_time' => 60,
            'gold_cost' => 10000,
            'gems_cost' => 0,
            'experience_reward' => 20
        ],
        [
            'id' => 16,
            'name' => 'Linen Loom',
            'type' => Task::TYPE_GATHER,
            'sub_type' => Task::GATHER_TYPE_WEAVING,
            'base_time' => 60,
            'gold_cost' => 10000,
            'gems_cost' => 0,
            'experience_reward' => 20
        ],
        [
            'id' => 17,
            'name' => 'Wool Loom',
            'type' => Task::TYPE_GATHER,
            'sub_type' => Task::GATHER_TYPE_WEAVING,
            'base_time' => 60,
            'gold_cost' => 10000,
            'gems_cost' => 0,
            'experience_reward' => 20
        ],
        [
            'id' => 18,
            'name' => 'Silk Loom',
            'type' => Task::TYPE_GATHER,
            'sub_type' => Task::GATHER_TYPE_WEAVING,
            'base_time' => 60,
            'gold_cost' => 10000,
            'gems_cost' => 0,
            'experience_reward' => 20
        ],
        [
            'id' => 19,
            'name' => 'Arcane Loom',
            'type' => Task::TYPE_GATHER,
            'sub_type' => Task::GATHER_TYPE_WEAVING,
            'base_time' => 60,
            'gold_cost' => 10000,
            'gems_cost' => 0,
            'experience_reward' => 20
        ],
        [
            'id' => 20,
            'name' => 'Dragon Loom',
            'type' => Task::TYPE_GATHER,
            'sub_type' => Task::GATHER_TYPE_WEAVING,
            'base_time' => 60,
            'gold_cost' => 10000,
            'gems_cost' => 0,
            'experience_reward' => 20
        ],
        //============================== Biology
        [
            'id' => 21,
            'name' => 'Goldbloom Fields',
            'type' => Task::TYPE_GATHER,
            'sub_type' => Task::GATHER_TYPE_BIOLOGY,
            'base_time' => 60,
            'gold_cost' => 10000,
            'gems_cost' => 0,
            'experience_reward' => 20
        ],
        [
            'id' => 22,
            'name' => 'Silverroot Fields',
            'type' => Task::TYPE_GATHER,
            'sub_type' => Task::GATHER_TYPE_BIOLOGY,
            'base_time' => 60,
            'gold_cost' => 10000,
            'gems_cost' => 0,
            'experience_reward' => 20
        ],
        [
            'id' => 23,
            'name' => 'Mindsage Fields',
            'type' => Task::TYPE_GATHER,
            'sub_type' => Task::GATHER_TYPE_BIOLOGY,
            'base_time' => 60,
            'gold_cost' => 10000,
            'gems_cost' => 0,
            'experience_reward' => 20
        ],
        [
            'id' => 24,
            'name' => 'Eaflari Fields',
            'type' => Task::TYPE_GATHER,
            'sub_type' => Task::GATHER_TYPE_BIOLOGY,
            'base_time' => 60,
            'gold_cost' => 10000,
            'gems_cost' => 0,
            'experience_reward' => 20
        ],
        [
            'id' => 25,
            'name' => 'Scourgemoss Fields',
            'type' => Task::TYPE_GATHER,
            'sub_type' => Task::GATHER_TYPE_BIOLOGY,
            'base_time' => 60,
            'gold_cost' => 10000,
            'gems_cost' => 0,
            'experience_reward' => 20
        ],
        [
            'id' => 26,
            'name' => 'Butchery',
            'type' => Task::TYPE_GATHER,
            'sub_type' => Task::GATHER_TYPE_BIOLOGY,
            'base_time' => 60,
            'gold_cost' => 10000,
            'gems_cost' => 0,
            'experience_reward' => 20
        ],
        [
            'id' => 27,
            'name' => 'Pheonixflower Fields',
            'type' => Task::TYPE_GATHER,
            'sub_type' => Task::GATHER_TYPE_BIOLOGY,
            'base_time' => 60,
            'gold_cost' => 10000,
            'gems_cost' => 0,
            'experience_reward' => 20
        ],

    ];

    private $skills = [
        //=============================Mining
        ['id' => 1, 'name' => 'Copper Mining', 'type' => Task::TYPE_GATHER, 'sub_type' => Task::GATHER_TYPE_MINING],
        ['id' => 2, 'name' => 'Coal Mining', 'type' => Task::TYPE_GATHER, 'sub_type' => Task::GATHER_TYPE_MINING],
        ['id' => 3, 'name' => 'Iron Mining', 'type' => Task::TYPE_GATHER, 'sub_type' => Task::GATHER_TYPE_MINING],
        ['id' => 4, 'name' => 'Orichalcum Mining', 'type' => Task::TYPE_GATHER, 'sub_type' => Task::GATHER_TYPE_MINING],
        ['id' => 5, 'name' => 'Mithril Mining', 'type' => Task::TYPE_GATHER, 'sub_type' => Task::GATHER_TYPE_MINING],
        ['id' => 6, 'name' => 'Podirian Mining', 'type' => Task::TYPE_GATHER, 'sub_type' => Task::GATHER_TYPE_MINING],
        ['id' => 7, 'name' => 'Gemstone Mining', 'type' => Task::TYPE_GATHER, 'sub_type' => Task::GATHER_TYPE_MINING],
        ['id' => 8, 'name' => 'Platinum Mining', 'type' => Task::TYPE_GATHER, 'sub_type' => Task::GATHER_TYPE_MINING],
        //=============================Tanning
        ['id' => 9, 'name' => 'Hide Tanning', 'type' => Task::TYPE_GATHER, 'sub_type' => Task::GATHER_TYPE_TANNING],
        ['id' => 10, 'name' => 'Leather Tanning', 'type' => Task::TYPE_GATHER, 'sub_type' => Task::GATHER_TYPE_TANNING],
        ['id' => 11, 'name' => 'Lizard skin Tanning', 'type' => Task::TYPE_GATHER, 'sub_type' => Task::GATHER_TYPE_TANNING],
        ['id' => 12, 'name' => 'Naga hide Tanning', 'type' => Task::TYPE_GATHER, 'sub_type' => Task::GATHER_TYPE_TANNING],
        ['id' => 13, 'name' => 'Daemon skin Tanning', 'type' => Task::TYPE_GATHER, 'sub_type' => Task::GATHER_TYPE_TANNING],
        ['id' => 14, 'name' => 'Dragon hide Tanning', 'type' => Task::TYPE_GATHER, 'sub_type' => Task::GATHER_TYPE_TANNING],
        //=============================Weaving
        ['id' => 15, 'name' => 'Cotton Weaving', 'type' => Task::TYPE_GATHER, 'sub_type' => Task::GATHER_TYPE_WEAVING],
        ['id' => 16, 'name' => 'Linen Weaving', 'type' => Task::TYPE_GATHER, 'sub_type' => Task::GATHER_TYPE_WEAVING],
        ['id' => 17, 'name' => 'Wool Weaving', 'type' => Task::TYPE_GATHER, 'sub_type' => Task::GATHER_TYPE_WEAVING],
        ['id' => 18, 'name' => 'Silk Weaving', 'type' => Task::TYPE_GATHER, 'sub_type' => Task::GATHER_TYPE_WEAVING],
        ['id' => 19, 'name' => 'Arcane cloth Weaving', 'type' => Task::TYPE_GATHER, 'sub_type' => Task::GATHER_TYPE_WEAVING],
        ['id' => 20, 'name' => 'Dragon silk Weaving', 'type' => Task::TYPE_GATHER, 'sub_type' => Task::GATHER_TYPE_WEAVING],
        //=============================Biology
        ['id' => 21, 'name' => 'Goldbloom Picking', 'type' => Task::TYPE_GATHER, 'sub_type' => Task::GATHER_TYPE_BIOLOGY],
        ['id' => 22, 'name' => 'Silverroot Picking', 'type' => Task::TYPE_GATHER, 'sub_type' => Task::GATHER_TYPE_BIOLOGY],
        ['id' => 23, 'name' => 'Mindsage Picking', 'type' => Task::TYPE_GATHER, 'sub_type' => Task::GATHER_TYPE_BIOLOGY],
        ['id' => 24, 'name' => 'Eaflari Picking', 'type' => Task::TYPE_GATHER, 'sub_type' => Task::GATHER_TYPE_BIOLOGY],
        ['id' => 25, 'name' => 'Scourgemoss Picking', 'type' => Task::TYPE_GATHER, 'sub_type' => Task::GATHER_TYPE_BIOLOGY],
        ['id' => 26, 'name' => 'Butchering', 'type' => Task::TYPE_GATHER, 'sub_type' => Task::GATHER_TYPE_BIOLOGY],
        ['id' => 27, 'name' => 'Pheonixflower Picking', 'type' => Task::TYPE_GATHER, 'sub_type' => Task::GATHER_TYPE_BIOLOGY],

        //=============================Mods
        //=============================Mining
        ['id' => 28, 'name' => 'Apprentice Mining', 'type' => Task::TYPE_GATHER, 'sub_type' => Task::GATHER_TYPE_MINING],
        ['id' => 29, 'name' => 'Journeyman Mining', 'type' => Task::TYPE_GATHER, 'sub_type' => Task::GATHER_TYPE_MINING],
        ['id' => 30, 'name' => 'Expert Mining', 'type' => Task::TYPE_GATHER, 'sub_type' => Task::GATHER_TYPE_MINING],
        ['id' => 31, 'name' => 'Master Mining', 'type' => Task::TYPE_GATHER, 'sub_type' => Task::GATHER_TYPE_MINING],
        //=============================Tanning
        ['id' => 32, 'name' => 'Apprentice Tanning', 'type' => Task::TYPE_GATHER, 'sub_type' => Task::GATHER_TYPE_TANNING],
        ['id' => 33, 'name' => 'Journeyman Tanning', 'type' => Task::TYPE_GATHER, 'sub_type' => Task::GATHER_TYPE_TANNING],
        ['id' => 34, 'name' => 'Expert Tanning', 'type' => Task::TYPE_GATHER, 'sub_type' => Task::GATHER_TYPE_TANNING],
        ['id' => 35, 'name' => 'Master Tanning', 'type' => Task::TYPE_GATHER, 'sub_type' => Task::GATHER_TYPE_TANNING],
        //=============================Weaving
        ['id' => 36, 'name' => 'Apprentice Weaving', 'type' => Task::TYPE_GATHER, 'sub_type' => Task::GATHER_TYPE_WEAVING],
        ['id' => 37, 'name' => 'Journeyman Weaving', 'type' => Task::TYPE_GATHER, 'sub_type' => Task::GATHER_TYPE_WEAVING],
        ['id' => 38, 'name' => 'Expert Weaving', 'type' => Task::TYPE_GATHER, 'sub_type' => Task::GATHER_TYPE_WEAVING],
        ['id' => 39, 'name' => 'Master Weaving', 'type' => Task::TYPE_GATHER, 'sub_type' => Task::GATHER_TYPE_WEAVING],
        //=============================Biology
        ['id' => 40, 'name' => 'Apprentice Biology', 'type' => Task::TYPE_GATHER, 'sub_type' => Task::GATHER_TYPE_BIOLOGY],
        ['id' => 41, 'name' => 'Journeyman Biology', 'type' => Task::TYPE_GATHER, 'sub_type' => Task::GATHER_TYPE_BIOLOGY],
        ['id' => 42, 'name' => 'Expert Biology', 'type' => Task::TYPE_GATHER, 'sub_type' => Task::GATHER_TYPE_BIOLOGY],
        ['id' => 43, 'name' => 'Master Biology', 'type' => Task::TYPE_GATHER, 'sub_type' => Task::GATHER_TYPE_BIOLOGY],
    ];
    private $task_skill_requirement = [
        //Mining
        ['task_id' => 1, 'skill_id' => 1],
        ['task_id' => 2, 'skill_id' => 2],
        ['task_id' => 3, 'skill_id' => 3],
        ['task_id' => 4, 'skill_id' => 4],
        ['task_id' => 5, 'skill_id' => 5],
        ['task_id' => 6, 'skill_id' => 6],
        ['task_id' => 7, 'skill_id' => 7],
        ['task_id' => 8, 'skill_id' => 8],
        //Tanning
        ['task_id' => 9, 'skill_id' => 9],
        ['task_id' => 10, 'skill_id' => 10],
        ['task_id' => 11, 'skill_id' => 11],
        ['task_id' => 12, 'skill_id' => 12],
        ['task_id' => 13, 'skill_id' => 13],
        ['task_id' => 14, 'skill_id' => 14],
        //Weaving
        ['task_id' => 15, 'skill_id' => 15],
        ['task_id' => 16, 'skill_id' => 16],
        ['task_id' => 17, 'skill_id' => 17],
        ['task_id' => 18, 'skill_id' => 18],
        ['task_id' => 19, 'skill_id' => 19],
        ['task_id' => 20, 'skill_id' => 20],
        //Biology
        ['task_id' => 21, 'skill_id' => 21],
        ['task_id' => 22, 'skill_id' => 22],
        ['task_id' => 23, 'skill_id' => 23],
        ['task_id' => 24, 'skill_id' => 24],
        ['task_id' => 25, 'skill_id' => 25],
        ['task_id' => 26, 'skill_id' => 26],
        ['task_id' => 27, 'skill_id' => 27],

    ];
    private $task_material_reward = [
        //Mining
        ['task_id' => 1, 'material_id' => 1, 'base_amount' => 10, 'base_chance' => 100],
        ['task_id' => 2, 'material_id' => 2, 'base_amount' => 50, 'base_chance' => 100],
        ['task_id' => 3, 'material_id' => 3, 'base_amount' => 8, 'base_chance' => 100],
        ['task_id' => 3, 'material_id' => 7, 'base_amount' => 1, 'base_chance' => 5],
        ['task_id' => 4, 'material_id' => 4, 'base_amount' => 6, 'base_chance' => 100],
        ['task_id' => 4, 'material_id' => 8, 'base_amount' => 1, 'base_chance' => 5],
        ['task_id' => 5, 'material_id' => 5, 'base_amount' => 4, 'base_chance' => 100],
        ['task_id' => 5, 'material_id' => 9, 'base_amount' => 1, 'base_chance' => 5],
        ['task_id' => 6, 'material_id' => 6, 'base_amount' => 3, 'base_chance' => 100],
        ['task_id' => 6, 'material_id' => 10, 'base_amount' => 1, 'base_chance' => 5],
        ['task_id' => 7, 'material_id' => 7, 'base_amount' => 1, 'base_chance' => 40],
        ['task_id' => 7, 'material_id' => 8, 'base_amount' => 1, 'base_chance' => 30],
        ['task_id' => 7, 'material_id' => 9, 'base_amount' => 1, 'base_chance' => 20],
        ['task_id' => 7, 'material_id' => 10, 'base_amount' => 1, 'base_chance' => 10],
        ['task_id' => 8, 'material_id' => 12, 'base_amount' => 2, 'base_chance' => 100],
        ['task_id' => 8, 'material_id' => 11, 'base_amount' => 1, 'base_chance' => 5],
        //Hides / Scales
        ['task_id' => 9, 'material_id' => 13, 'base_amount' => 10, 'base_chance' => 100],
        ['task_id' => 10, 'material_id' => 14, 'base_amount' => 8, 'base_chance' => 100],
        ['task_id' => 11, 'material_id' => 15, 'base_amount' => 6, 'base_chance' => 100],
        ['task_id' => 12, 'material_id' => 16, 'base_amount' => 4, 'base_chance' => 100],
        ['task_id' => 13, 'material_id' => 17, 'base_amount' => 3, 'base_chance' => 100],
        ['task_id' => 14, 'material_id' => 18, 'base_amount' => 2, 'base_chance' => 75],
        ['task_id' => 14, 'material_id' => 19, 'base_amount' => 2, 'base_chance' => 25],
        //Weaving
        ['task_id' => 15, 'material_id' => 20, 'base_amount' => 10, 'base_chance' => 100],
        ['task_id' => 16, 'material_id' => 21, 'base_amount' => 8, 'base_chance' => 100],
        ['task_id' => 17, 'material_id' => 22, 'base_amount' => 6, 'base_chance' => 100],
        ['task_id' => 18, 'material_id' => 23, 'base_amount' => 4, 'base_chance' => 100],
        ['task_id' => 19, 'material_id' => 24, 'base_amount' => 3, 'base_chance' => 100],
        ['task_id' => 20, 'material_id' => 25, 'base_amount' => 2, 'base_chance' => 100],
        //Biology
        ['task_id' => 21, 'material_id' => 26, 'base_amount' => 10, 'base_chance' => 100],
        ['task_id' => 22, 'material_id' => 27, 'base_amount' => 8, 'base_chance' => 100],
        ['task_id' => 23, 'material_id' => 28, 'base_amount' => 6, 'base_chance' => 100],
        ['task_id' => 24, 'material_id' => 29, 'base_amount' => 4, 'base_chance' => 100],
        ['task_id' => 25, 'material_id' => 30, 'base_amount' => 3, 'base_chance' => 100],
        ['task_id' => 26, 'material_id' => 31, 'base_amount' => 1, 'base_chance' => 30],
        ['task_id' => 26, 'material_id' => 32, 'base_amount' => 1, 'base_chance' => 30],
        ['task_id' => 26, 'material_id' => 33, 'base_amount' => 1, 'base_chance' => 15],
        ['task_id' => 26, 'material_id' => 34, 'base_amount' => 1, 'base_chance' => 15],
        ['task_id' => 26, 'material_id' => 35, 'base_amount' => 1, 'base_chance' => 10],
        ['task_id' => 27, 'material_id' => 36, 'base_amount' => 2, 'base_chance' => 100],
    ];

    private $skill_skill_requirement = [
        //Mining
        ['skill_id' => 2, 'required_skill_id' => 1],
        ['skill_id' => 3, 'required_skill_id' => 2],
        ['skill_id' => 4, 'required_skill_id' => 3],
        ['skill_id' => 5, 'required_skill_id' => 4],
        ['skill_id' => 6, 'required_skill_id' => 5],
        ['skill_id' => 7, 'required_skill_id' => 31],
        ['skill_id' => 7, 'required_skill_id' => 6],
        ['skill_id' => 8, 'required_skill_id' => 7],
        //Mods
        ['skill_id' => 28, 'required_skill_id' => 1],
        ['skill_id' => 29, 'required_skill_id' => 28],
        ['skill_id' => 30, 'required_skill_id' => 29],
        ['skill_id' => 31, 'required_skill_id' => 30],
        //Tanning
        ['skill_id' => 10, 'required_skill_id' => 9],
        ['skill_id' => 11, 'required_skill_id' => 10],
        ['skill_id' => 12, 'required_skill_id' => 11],
        ['skill_id' => 13, 'required_skill_id' => 12],
        ['skill_id' => 14, 'required_skill_id' => 13],
        ['skill_id' => 14, 'required_skill_id' => 35],
        //Mods
        ['skill_id' => 32, 'required_skill_id' => 9],
        ['skill_id' => 33, 'required_skill_id' => 32],
        ['skill_id' => 34, 'required_skill_id' => 33],
        ['skill_id' => 35, 'required_skill_id' => 34],
        //Weaving
        ['skill_id' => 16, 'required_skill_id' => 15],
        ['skill_id' => 17, 'required_skill_id' => 16],
        ['skill_id' => 18, 'required_skill_id' => 17],
        ['skill_id' => 19, 'required_skill_id' => 18],
        ['skill_id' => 20, 'required_skill_id' => 19],
        ['skill_id' => 20, 'required_skill_id' => 39],
        //Mods
        ['skill_id' => 36, 'required_skill_id' => 15],
        ['skill_id' => 37, 'required_skill_id' => 36],
        ['skill_id' => 38, 'required_skill_id' => 37],
        ['skill_id' => 39, 'required_skill_id' => 38],
        //Biology
        ['skill_id' => 22, 'required_skill_id' => 21],
        ['skill_id' => 23, 'required_skill_id' => 22],
        ['skill_id' => 24, 'required_skill_id' => 23],
        ['skill_id' => 25, 'required_skill_id' => 24],
        ['skill_id' => 26, 'required_skill_id' => 25],
        ['skill_id' => 27, 'required_skill_id' => 26],
        ['skill_id' => 27, 'required_skill_id' => 43],
        //Mods
        ['skill_id' => 40, 'required_skill_id' => 21],
        ['skill_id' => 41, 'required_skill_id' => 40],
        ['skill_id' => 42, 'required_skill_id' => 41],
        ['skill_id' => 43, 'required_skill_id' => 42],
    ];

    private $skill_task_modifier = [
        //Mining
        ['skill_id'=>28, 'task_type' => Task::TYPE_GATHER, 'task_sub_type' => Task::GATHER_TYPE_MINING, 'reward_modifier' => 10, 'chance_modifier'=> 10 ],
        ['skill_id'=>29, 'task_type' => Task::TYPE_GATHER, 'task_sub_type' => Task::GATHER_TYPE_MINING, 'reward_modifier' => 10, 'chance_modifier'=> 10 ],
        ['skill_id'=>30, 'task_type' => Task::TYPE_GATHER, 'task_sub_type' => Task::GATHER_TYPE_MINING, 'reward_modifier' => 10, 'chance_modifier'=> 10 ],
        ['skill_id'=>31, 'task_type' => Task::TYPE_GATHER, 'task_sub_type' => Task::GATHER_TYPE_MINING, 'reward_modifier' => 20, 'chance_modifier'=> 20 ],
        //Tanning
        ['skill_id'=>32, 'task_type' => Task::TYPE_GATHER, 'task_sub_type' => Task::GATHER_TYPE_TANNING, 'reward_modifier' => 10, 'chance_modifier'=> 10 ],
        ['skill_id'=>33, 'task_type' => Task::TYPE_GATHER, 'task_sub_type' => Task::GATHER_TYPE_TANNING, 'reward_modifier' => 10, 'chance_modifier'=> 10 ],
        ['skill_id'=>34, 'task_type' => Task::TYPE_GATHER, 'task_sub_type' => Task::GATHER_TYPE_TANNING, 'reward_modifier' => 10, 'chance_modifier'=> 10 ],
        ['skill_id'=>35, 'task_type' => Task::TYPE_GATHER, 'task_sub_type' => Task::GATHER_TYPE_TANNING, 'reward_modifier' => 20, 'chance_modifier'=> 20 ],
        //Weaving
        ['skill_id'=>36, 'task_type' => Task::TYPE_GATHER, 'task_sub_type' => Task::GATHER_TYPE_WEAVING, 'reward_modifier' => 10, 'chance_modifier'=> 10 ],
        ['skill_id'=>37, 'task_type' => Task::TYPE_GATHER, 'task_sub_type' => Task::GATHER_TYPE_WEAVING, 'reward_modifier' => 10, 'chance_modifier'=> 10 ],
        ['skill_id'=>38, 'task_type' => Task::TYPE_GATHER, 'task_sub_type' => Task::GATHER_TYPE_WEAVING, 'reward_modifier' => 10, 'chance_modifier'=> 10 ],
        ['skill_id'=>39, 'task_type' => Task::TYPE_GATHER, 'task_sub_type' => Task::GATHER_TYPE_WEAVING, 'reward_modifier' => 20, 'chance_modifier'=> 20 ],
        //Biology
        ['skill_id'=>40, 'task_type' => Task::TYPE_GATHER, 'task_sub_type' => Task::GATHER_TYPE_BIOLOGY, 'reward_modifier' => 10, 'chance_modifier'=> 10 ],
        ['skill_id'=>41, 'task_type' => Task::TYPE_GATHER, 'task_sub_type' => Task::GATHER_TYPE_BIOLOGY, 'reward_modifier' => 10, 'chance_modifier'=> 10 ],
        ['skill_id'=>42, 'task_type' => Task::TYPE_GATHER, 'task_sub_type' => Task::GATHER_TYPE_BIOLOGY, 'reward_modifier' => 10, 'chance_modifier'=> 10 ],
        ['skill_id'=>43, 'task_type' => Task::TYPE_GATHER, 'task_sub_type' => Task::GATHER_TYPE_BIOLOGY, 'reward_modifier' => 20, 'chance_modifier'=> 20 ],
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('materials')->insert($this->materials);
        DB::table('items')->insert($this->items);
        DB::table('tasks')->insert($this->tasks);
        DB::table('skills')->insert($this->skills);
        DB::table('task_material_reward')->insert($this->task_material_reward);
        DB::table('task_skill_requirement')->insert($this->task_skill_requirement);
        DB::table('skill_skill_requirement')->insert($this->skill_skill_requirement);
        DB::table('skill_task_modifier')->insert($this->skill_task_modifier);
        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
