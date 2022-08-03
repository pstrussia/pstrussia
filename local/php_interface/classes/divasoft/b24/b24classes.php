<?php
//$bx24 = new Bitrix24(IN_DOMAIN, IN_USER, IN_TOKEN);
class Bitrix24
{
	/**
	 * Идентификатор пользователя вебхука
	 * @var int
	 */
	private $userId;

	/**
	 * Хэш вебхука
	 * @var string
	 */
	private $webhook;

	/**
	 * Конструктор класса
	 * @param int $userId идентификатор пользоателя вебхука
	 * @param string $webhook хэш вебхука
	 */
	public function __construct($url, $userId, $webhook)
	{
		$this->url = $url;
		$this->userId = (int)$userId;
		$this->webhook = $webhook;
	}

	/**
	 * Получение URL метода вебхука
	 * @param string $action имя метода
	 * @return string
	 */
	public function getRestUrl($action)
	{
		return 'https://'.$this->url."/rest/{$this->userId}/{$this->webhook}/{$action}";
	}

	/**
	 * Получение списка доступных полей контакта
	 *
	 * @return []
	 */
	
	public function getContactFields()
	{
		return $this->send('crm.contact.fields.json');
	}
	
	/**
	 * Получение списка доступных полей лида
	 *
	 * @return []
	 */
	public function getLeadFields()
	{
		return $this->send('crm.lead.fields.json');
	}
	
	/**
	 * Получение списка доступных полей сделки
	 *
	 * @return []
	 */
	public function getDealFields()
	{
		return $this->send('crm.deal.fields.json');
	}

	/**
	 * Получение контакта
	 *
	 * @return []
	 */
	public function getContact($id)
	{
		return $this->send('crm.contact.get.json', [
			'id' => $id,
			]
		);
	}

	/**
	 * Получение лида
	 *
	 * @return []
	 */
	public function getLead($id)
	{
		return $this->send('crm.lead.get.json', [
			'id' => $id,
			]
		);
	}

	/**
	 * Получение сделки
	 *
	 * @return []
	 */
	public function getDeal($id)
	{
		return $this->send('crm.deal.get.json', [
			'id' => $id,
			]
		);
	}
	
	/**
	 * Получение контактов по фильтру
	 *
	 * @return []
	 */
	public function getListContact($select, $filter)
	{
		return $this->send('crm.contact.list.json', [
			'select' => $select,
			'filter' => $filter
			]
		);
	}
	
	/**
	 * Получение сделок по фильтру
	 *
	 * @return []
	 */
	public function getListDeal($select, $filter)
	{
		return $this->send('crm.deal.list.json', [
			'select' => $select,
			'filter' => $filter
			]
		);
	}	
	
	/**
	 * Обновлениие лида
	 *
	 * @return []
	 */
	public function updateLead($id, $fields, $assignedById = null, $sonet = false)
	{
		
		$normalizedFields = [];
		foreach ($fields as $key => $value) {
			if (preg_match('/^(?<name>EMAIL|PHONE|IM|WEB)_(?<type>.*)$/', strtoupper($key), $m)) {
				$normalizedFields[$m['name']]['n' . count($normalizedFields[$m['name']] ?? [])] = [
					'VALUE' => ($m['name'] == 'PHONE')
						? ('+' . preg_replace(['/[^0-9]+/', '/^8/'], ['', '7'], $value))
						: trim($value),
					'VALUE_TYPE' => $m['type']
				];
			} else {
				$normalizedFields[$key] = trim($value);
			}
		}
		
		if ($assignedById) {
			$normalizedFields['ASSIGNED_BY_ID'] = $assignedById;
		}
		
		return $this->send('crm.lead.update.json', [
			'id' => $id,
			'fields' => $normalizedFields,
			'params' => $sonet ? ['REGISTER_SONET_EVENT' => 'Y'] : []
		]);
	}
	
	/**
	 * Обновлениие сделки
	 *
	 * @return []
	 */
	public function updateDeal($id, $fields, $assignedById = null, $sonet = false)
	{
		
		$normalizedFields = [];
		foreach ($fields as $key => $value) {
			if (preg_match('/^(?<name>EMAIL|PHONE|IM|WEB)_(?<type>.*)$/', strtoupper($key), $m)) {
				$normalizedFields[$m['name']]['n' . count($normalizedFields[$m['name']] ?? [])] = [
					'VALUE' => ($m['name'] == 'PHONE')
						? ('+' . preg_replace(['/[^0-9]+/', '/^8/'], ['', '7'], $value))
						: trim($value),
					'VALUE_TYPE' => $m['type']
				];
			} else {
				$normalizedFields[$key] = trim($value);
			}
		}
		
		if ($assignedById) {
			$normalizedFields['ASSIGNED_BY_ID'] = $assignedById;
		}
		
		return $this->send('crm.deal.update.json', [
			'id' => $id,
			'fields' => $normalizedFields,
			'params' => $sonet ? ['REGISTER_SONET_EVENT' => 'Y'] : []
		]);
	}
	
	
	/**
	 * Создание контакта
	 *
	 * @param [] $fields Поля для создания контакта вида [name=>value].
	 * @param int|null $assignedById Идентификатор отвественного пользователя. 
	 * По умолчанию (null) не назначен.
	 * @param bool $sonet произвести регистрацию события добавления контакта в живой ленте. 
	 * По умолчанию (true) - произвести регистрацию события.
	 * @return [] результат добавления контакта
	 */
	public function createContact($fields, $assignedById = null, $sonet = false)
	{
		// нормализация данных
		$normalizedFields = [];
		foreach ($fields as $key => $value) {
			
			if (preg_match('/^(?<name>EMAIL|PHONE|IM|WEB)_(?<type>.*)$/', strtoupper($key), $m)) {
				$normalizedFields[$m['name']]['n' . count($normalizedFields[$m['name']] ?? [])] = [
					'VALUE' => ($m['name'] == 'PHONE')
						? ('+' . preg_replace(['/[^0-9]+/', '/^8/'], ['', '7'], $value))
						: trim($value),
					'VALUE_TYPE' => $m['type']
				];
			} else {
				$normalizedFields[$key] = trim($value);
			}
		}
		
		// Если статус заявки не передан явно, устанавливаем его в значение "NEW" (новая)
		$normalizedFields['STATUS_ID'] = $normalizedFields['STATUS_ID'] ?? 'NEW';

		// Если источник заявки не передан явно, устанавливаем его в значение "WEB" (веб-сайт)
		$normalizedFields['SOURCE_ID'] = $normalizedFields['SOURCE_ID'] ?? 'WEB';

		if ($assignedById) {
			$normalizedFields['ASSIGNED_BY_ID'] = $assignedById;
		}
		

		// выполение запроса на создание лида
		return $this->send('crm.contact.add.json', [
			'fields' => $normalizedFields,
			'params' => $sonet ? ['REGISTER_SONET_EVENT' => 'Y'] : []
		]);
	}
	
	/**
	 * Создание лида
	 *
	 * @param [] $fields Поля для создания лида вида [name=>value].
	 * @param int|null $assignedById Идентификатор отвественного пользователя. 
	 * По умолчанию (null) не назначен.
	 * @param bool $sonet произвести регистрацию события добавления лида в живой ленте. 
	 * По умолчанию (true) - произвести регистрацию события.
	 * @return [] результат добавления лида
	 */
	public function createLead($fields, $assignedById = null, $sonet = false)
	{
		// нормализация данных
		$normalizedFields = [];
		foreach ($fields as $key => $value) {
			if (preg_match('/^(?<name>EMAIL|PHONE|IM|WEB)_(?<type>.*)$/', strtoupper($key), $m)) {
				$normalizedFields[$m['name']]['n' . count($normalizedFields[$m['name']] ?? [])] = [
					'VALUE' => ($m['name'] == 'PHONE')
						? ('+' . preg_replace(['/[^0-9]+/', '/^8/'], ['', '7'], $value))
						: trim($value),
					'VALUE_TYPE' => $m['type']
				];
			} else {
				$normalizedFields[$key] = trim($value);
			}
		}

		// Если статус заявки не передан явно, устанавливаем его в значение "NEW" (новая)
		$normalizedFields['STATUS_ID'] = $normalizedFields['STATUS_ID'] ?? 'NEW';

		// Если источник заявки не передан явно, устанавливаем его в значение "WEB" (веб-сайт)
		$normalizedFields['SOURCE_ID'] = $normalizedFields['SOURCE_ID'] ?? 'WEB';

		if ($assignedById) {
			$normalizedFields['ASSIGNED_BY_ID'] = $assignedById;
		}

		// выполение запроса на создание лида
		return $this->send('crm.lead.add.json', [
			'fields' => $normalizedFields,
			'params' => $sonet ? ['REGISTER_SONET_EVENT' => 'Y'] : []
		]);
	}
	
	/**
	 * Создание сделки
	 *
	 * @param [] $fields Поля для создания лида вида [name=>value].
	 * @param int|null $assignedById Идентификатор отвественного пользователя. 
	 * По умолчанию (null) не назначен.
	 * @param bool $sonet произвести регистрацию события добавления лида в живой ленте. 
	 * По умолчанию (true) - произвести регистрацию события.
	 * @return [] результат добавления лида
	 */
	public function createDeal($fields, $assignedById = null, $sonet = false)
	{
		// нормализация данных
		$normalizedFields = [];
		foreach ($fields as $key => $value) {
			if (preg_match('/^(?<name>EMAIL|PHONE|IM|WEB)_(?<type>.*)$/', strtoupper($key), $m)) {
				$normalizedFields[$m['name']]['n' . count($normalizedFields[$m['name']] ?? [])] = [
					'VALUE' => ($m['name'] == 'PHONE')
						? ('+' . preg_replace(['/[^0-9]+/', '/^8/'], ['', '7'], $value))
						: trim($value),
					'VALUE_TYPE' => $m['type']
				];
			} else {
				$normalizedFields[$key] = trim($value);
			}
		}

		// Если статус заявки не передан явно, устанавливаем его в значение "NEW" (новая)
		$normalizedFields['STATUS_ID'] = $normalizedFields['STATUS_ID'] ?? 'NEW';

		// Если источник заявки не передан явно, устанавливаем его в значение "WEB" (веб-сайт)
		$normalizedFields['SOURCE_ID'] = $normalizedFields['SOURCE_ID'] ?? 'WEB';

		if ($assignedById) {
			$normalizedFields['ASSIGNED_BY_ID'] = $assignedById;
		}

		// выполение запроса на создание лида
		return $this->send('crm.deal.add.json', [
			'fields' => $normalizedFields,
			'params' => $sonet ? ['REGISTER_SONET_EVENT' => 'Y'] : []
		]);
	}
	
	
	public function getDuplicate ($entity_type, $type, $values) {
		
		return $this->send('crm.duplicate.findbycomm.json', [
			'entity_type' => $entity_type,
			'type' => $type,
			'values' => $values
		]);
		
	}

	/**
	 * Отправка запроса
	 *
	 * @param string $action имя метода
	 * @param [] $data дополнительные данные. По умолчанию [] (пустой массив).
	 * @return [] в случае успеха, возвращает массив JSON декодированных данных.
	 */
	public function send($action, $data = [])
	{

		$ch = curl_init($this->getRestUrl($action));

		curl_setopt_array($ch, [
			CURLOPT_POST => 1,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_SSL_VERIFYPEER => 0,
			CURLOPT_HEADER => 0,
			CURLOPT_POSTFIELDS => http_build_query($data),
		]);

		if (!$result = curl_exec($ch)) {
			trigger_error(curl_error($ch));
		} elseif (!$result = json_decode($result, true)) {
			trigger_error(json_last_error());
		} elseif (array_key_exists('error', $result)) {
			trigger_error($result['error_description']);
		}

		return $result;
	}
}