<?php

namespace App\Http\Livewire;
namespace App\Livewire;
use App\Models\userhierarchytab;
use App\Models\userroletab;
use Livewire\Component;

class Allhierarchydata extends Component
{
   public $alldata;
    public $id;

    public function mount($id)
    {
        $this->id = $id;
        $this->alldata = userhierarchytab::findOrFail($id);
    }

    public function getDirectChildren($users, $parentId)
    {
        $children = [];

        foreach ($users as $user) {
            // direct hierarchy only
            // 1. first priority = assignid
            if (!empty($user->assignid) && (int) $user->assignid === (int) $parentId) {
                $children[] = $user;
            }
            // 2. if assignid empty, then zonalId
            elseif (empty($user->assignid) && !empty($user->zonalId) && (int) $user->zonalId === (int) $parentId) {
                $children[] = $user;
            }
        }

        return collect($children)->sortBy('id')->values();
    }

    public function renderTree($users, $parentId, $categories, &$visited = [])
    {
        $children = $this->getDirectChildren($users, $parentId);

        if ($children->isEmpty()) {
            return '';
        }

        $html = '<ul>';

        foreach ($children as $user) {
            if (in_array($user->id, $visited)) {
                continue;
            }

            $visited[] = $user->id;
            $roleName = isset($categories[$user->roleid]) ? $categories[$user->roleid]->role : 'No Role';
            $hasChildren = $this->getDirectChildren($users, $user->id)->count() > 0;

            $html .= '<li>';

            if ($hasChildren) {
                $html .= '<input type="checkbox" id="user-checkbox-' . $user->id . '" />';
                $html .= '<label class="tree_label" for="user-checkbox-' . $user->id . '">';
                $html .= '(' . $roleName . ') ' . e($user->username) . ' (' . e($user->registerid) . ')';
                $html .= '</label>';
                $html .= $this->renderTree($users, $user->id, $categories, $visited);
            } else {
                $html .= '<span class="tree_label">';
                $html .= '(' . $roleName . ') ' . e($user->username) . ' (' . e($user->registerid) . ')';
                $html .= '</span>';
            }

            $html .= '</li>';
        }

        $html .= '</ul>';

        return $html;
    }

    public function render()
    {
        $users = userhierarchytab::where('active', 'Active')->get();
        $categories = userroletab::all()->keyBy('id');

        return view('livewire.allhierarchydata', [
            'userdata' => $users,
            'category' => $categories,
        ])->layout('layouts.header');
    }
}