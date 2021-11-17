{% extends "base.html.twig" %}

{% block body %}
<?php if ($has_form) {?>
    {{ form_start(vm.form) }}
        {{ form_errors(vm.form) }}
        {{ form_rest(vm.form) }}
        <button>Valid</button>
    {{ form_end(vm.form) }}
<?php }?>
{% endblock %}
