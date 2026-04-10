<div>
    <style>
        /* Tree structure styling */
        .tree {
            margin: 1em;
        }

        .tree input {
            position: absolute;
            clip: rect(0, 0, 0, 0);
        }

        .tree input~ul {
            display: none;
        }

        .tree input:checked~ul {
            display: block;
        }

        .tree li {
            line-height: 1.2;
            position: relative;
            padding: 0 0 1em 1em;
        }

        .tree ul li {
            padding: 1em 0 0 1em;
        }

        .tree_label {
            position: relative;
            display: inline-block;
            background: #fff;
            cursor: pointer;
        }

        label.tree_label:before {
            background: #000;
            color: #fff;
            position: relative;
            float: left;
            margin: 0 1em 0 -2em;
            width: 1em;
            height: 1em;
            border-radius: 1em;
            content: '+';
            text-align: center;
            line-height: .9em;
        }

        :checked~label.tree_label:before {
            content: '–';
        }

        .tree li:before {
            position: absolute;
            top: 0;
            bottom: 0;
            left: -.5em;
            display: block;
            width: 0;
            border-left: 1px solid #777;
            content: "";
        }

        .tree li:last-child:before {
            height: 1em;
            bottom: auto;
        }
    </style>


    <h2>User Hierarchy Starting from {{ $alldata->username }}</h2>
      <div class="card mt-3">
    <div class="card-body">
        <p>{{ $alldata->username }}</p>

        <ul class="tree">
            @php
                $visited = [$alldata->id];
            @endphp

            {!! $this->renderTree($userdata, $alldata->id, $category, $visited) !!}
        </ul>
    </div>
</div>
</div>