{% if sizeof(pager.getLinks()) > 1 %}
    <div class="text-center">
            <ul class="pagination">
                {% if pager.before != pager.current %}
                    <li><a href="?page={{ pager.before }}{{ pager_query }}"><- Сюда</a></li>
                {% endif %}
                {% for page in pager.getLinks() %}
                    {% if page == pager.current %}
                    <li class="active"><a>{{ page }}</a></li>
                    {% else %}
                        <li>
                            <a href="?page={{ page }}{{ pager_query }}">{{ page }}</a>
                        </li>
                    {% endif %}
                {% endfor %}
                {% if pager.next != pager.current %}
                    <li><a href="?page={{ pager.next }}{{ pager_query }}">Туда -></a></li>
                {% endif %}
            </ul>
    </div>
    <div class="clear"></div>
{% endif %}