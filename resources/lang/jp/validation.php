<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages.
    |
    */
    'accepted' => ':attributeチェックして下さい',
    'active_url' => ':attribute有効なURLではありません',
    'after' => ':attribute:dateより後の日付を指定してください',
    'after_or_equal' => ':attribute:date以降の日付を指定してください',
    'alpha' => ':attribute アルファベッドのみ使用できます',
    'alpha_dash' => ":attribute 英数字('A-Z','a-z','0-9')とハイフンと下線('-','_')が使用できます",
    'alpha_num' => ":attribute 英数字('A-Z','a-z','0-9')が使用できます",
    'array' => ':attribute 配列を指定してください',
    'before' => ':attribute :dateより前の日付を指定してください',
    'before_or_equal' => ':attribute :date以前の日付を指定してください',
    'between' => [
        'numeric' => ':attribute :minから、:maxまでの数字を指定してください',
        'file' => ':attribute :min KBから:max KBまでのサイズのファイルを指定してください',
        'string' => ':attribute :min文字から:max文字にしてください',
        'array' => ':attributeの項目は、:min個から:max個にしてください',
    ],
    'boolean' => ":attribute 'true'か'false'を指定してください",
    'confirmed' => ':attributeと:attribute確認が一致しません',
    'date' => ':attribute 正しい日付ではありません',
    'date_equals' => ':attributeは:dateに等しい日付でなければなりません',
    'date_format' => ":attributeの形式は、':format'と合いません",
    'different' => ':attributeと:otherには、異なるものを指定してください',
    'digits' => ':attribute :digits桁にしてください',
    'digits_between' => ':attribute :min桁から:max桁にしてください',
    'dimensions' => ':attributeの画像サイズが無効です',
    'distinct' => ':attributeの値が重複しています',
    'email' => ':attribute 有効なメールアドレスを入力してください',
    'ends_with' => 'The :attribute must end with one of the following: :values',
    'exists' => '選択された:attribute 有効ではありません',
    'file' => ':attributeはファイルでなければいけません',
    'filled' => ':attributeは必須です',
    'gt' => [
        'numeric' => ':attribute :valueより大きくなければなりません',
        'file' => ':attribute :value KBより大きくなければなりません',
        'string' => ':attribute :value文字より大きくなければなりません',
        'array' => ':attributeの項目数は、:value個より大きくなければなりません',
    ],
    'gte' => [
        'numeric' => ':attribute :value以上でなければなりません',
        'file' => ':attribute :value KB以上でなければなりません',
        'string' => ':attribute :value文字以上でなければなりません',
        'array' => ':attributeの項目数は、:value個以上でなければなりません',
    ],
    'image' => ':attribute 画像を指定してください',
    'in' => '選択された:attribute 有効ではありません',
    'in_array' => ':attributeが:otherに存在しません',
    'integer' => ':attribute 整数を指定してください',
    'ip' => ':attribute 有効なIPアドレスを指定してください',
    'ipv4' => ':attributeはIPv4アドレスを指定してください',
    'ipv6' => ':attributeはIPv6アドレスを指定してください',
    'json' => ':attribute 有効なJSON文字列を指定してください',
    'lt' => [
        'numeric' => ':attribute :valueより小さくなければなりません',
        'file' => ':attribute :value KBより小さくなければなりません',
        'string' => ':attribute :value文字より小さくなければなりません',
        'array' => ':attributeの項目数は、:value個より小さくなければなりません',
    ],
    'lte' => [
        'numeric' => ':attribute :value以下でなければなりません',
        'file' => ':attribute :value KB以下でなければなりません',
        'string' => ':attribute :value文字以下でなければなりません',
        'array' => ':attributeの項目数は、:value個以下でなければなりません',
    ],
    'max' => [
        'numeric' => ':attribute :max以下の数字を指定してください',
        'file' => ':attribute :max KB以下のファイルを指定してください',
        'string' => ':attribute :max文字以下にしてください',
        'array' => ':attributeの項目は、:max個以下にしてください',
    ],
    'mimes' => ':attribute :valuesタイプのファイルを指定してください',
    'mimetypes' => ':attribute :valuesタイプのファイルを指定してください',
    'min' => [
        'numeric' => ':attribute :min以上の数字を指定してください',
        'file' => ':attribute :min KB以上のファイルを指定してください',
        'string' => ':attribute :min文字以上にしてください',
        'array' => ':attributeの項目は、:min個以上にしてください',
    ],
    'not_in' => '選択された:attribute 有効ではありません',
    'not_regex' => ':attributeの形式が無効です',
    'numeric' => ':attribute 数字を指定してください',
    'present' => ':attributeが存在している必要があります',
    'regex' => ':attribute 有効な正規表現を指定してください',
    'required' => '入力してください',
    'required_if' => ':otherが:valueの場合、:attributeを指定してください',
    'required_unless' => ':otherが:values以外の場合、:attributeを指定してください',
    'required_with' => ':valuesが指定されている場合、:attributeも指定してください',
    'required_with_all' => ':valuesが全て指定されている場合、:attributeも指定してください',
    'required_without' => ':valuesが指定されていない場合、:attributeを指定してください',
    'required_without_all' => ':valuesが全て指定されていない場合、:attributeを指定してください',
    'same' => ':attribute:otherが一致しません',
    'size' => [
        'numeric' => ':attribute :sizeを指定してください',
        'file' => ':attribute :size KBのファイルを指定してください',
        'string' => ':attribute :size文字にしてください',
        'array' => ':attributeの項目は、:size個にしてください',
    ],
    'starts_with' => ':attribute 次のいずれかで始まる必要があります:values',
    'string' => ':attribute 文字を指定してください',
    'timezone' => ':attribute 有効なタイムゾーンを指定してください',
    'unique' => ':attribute メールアドレスはすでに 登録されています',
    'uploaded' => ':attributeアップロードに失敗しました',
    'url' => ':attribute 有効なURL形式で指定してください',
    'uuid' => ':attribute 有効なUUIDでなければなりません',
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */
    'custom' => [
        'tel' => [
            'unique' => '電話番号はすでに存在しています',
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */
    'attributes' => [
        "'email' => ' ',
        'password' => ' ',
        'password_confirmation' => ' ',
        'name' => ' ',
        'birthday' => ' '"
    ],
];
