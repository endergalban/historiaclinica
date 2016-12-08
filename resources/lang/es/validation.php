<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'El campo :attribute debe ser aceptado.',
    'active_url'           => 'El campo :attribute no es una URL válida.',
    'after'                => 'El campo :attribute debe ser una fecha posterior a :date.',
    'alpha'                => 'El campo :attribute sólo puede contener letras.',
    'alpha_dash'           => 'El campo :attribute sólo puede contener letras, números y guiones (a-z, 0-9, -_).',
    'alpha_num'            => 'El campo :attribute sólo puede contener letras y números.',
    'array'                => 'El campo :attribute debe ser un array.',
    'before'               => 'El campo :attribute debe ser una fecha anterior a :date.',
    
    'between'              => [
        'numeric' => 'El campo :attribute debe ser un valor entre :min y :max.',
        'file'    => 'El archivo :attribute debe pesar entre :min y :max kilobytes.',
        'string'  => 'El campo :attribute debe contener entre :min y :max caracteres.',
        'array'   => 'El campo :attribute debe contener entre :min y :max elementos.',
    ],
    'boolean'              => 'El campo :attribute debe ser verdadero o falso.',
    'confirmed'            => 'El campo confirmación de :attribute no coincide.',
    'country'              => 'El campo :attribute no es un país válido.',
    'date'                 => 'El campo :attribute no corresponde con una fecha válida.',
    'date_format'          => 'El campo :attribute no corresponde con el formato de fecha :format.',
    'different'            => 'Los campos :attribute y :other han de ser diferentes.',
    'digits'               => 'El campo :attribute debe ser un número de :digits dígitos.',
    'digits_between'       => 'El campo :attribute debe contener entre :min y :max dígitos.',
    'distinct'             => 'El campo :attribute tiene un valor duplicado.',
    'email'                => 'El campo :attribute no corresponde con una dirección de e-mail válida.',
    'filled'               => 'El campo :attribute es obligatorio.',
    'exists'               => 'El campo :attribute no existe.',
    'image'                => 'El campo :attribute debe ser una imagen.',
    'in'                   => 'El campo :attribute debe ser igual a alguno de estos valores :values',
    'in_array'             => 'El campo :attribute no existe en :other.',
    'integer'              => 'El campo :attribute debe ser un número entero.',
    'ip'                   => 'El campo :attribute debe ser una dirección IP válida.',
    'json'                 => 'El campo :attribute debe ser una cadena de texto JSON válida.',
    'max'                  => [
        'numeric' => 'El campo :attribute debe ser :max como máximo.',
        'file'    => 'El archivo :attribute debe pesar :max kilobytes como máximo.',
        'string'  => 'El campo :attribute debe contener :max caracteres como máximo.',
        'array'   => 'El campo :attribute debe contener :max elementos como máximo.',
    ],
    'mimes'                => 'El campo :attribute debe ser un archivo de tipo :values.',
    'min'                  => [
        'numeric' => 'El campo :attribute debe tener al menos :min.',
        'file'    => 'El archivo :attribute debe pesar al menos :min kilobytes.',
        'string'  => 'El campo :attribute debe contener al menos :min caracteres.',
        'array'   => 'El campo :attribute no debe contener más de :min elementos.',
    ],
    'not_in'               => 'El campo :attribute seleccionado es invalido.',
    'numeric'              => 'El campo :attribute debe ser un numero.',
    'present'              => 'El campo :attribute debe estar presente.',
    'regex'                => 'El formato del campo :attribute es inválido.',
    'required'             => 'El campo :attribute es obligatorio',
    'required_if'          => 'El campo :attribute es obligatorio cuando el campo :other es :value.',
    'required_unless'      => 'El campo :attribute es requerido a menos que :other se encuentre en :values.',
    'required_with'        => 'El campo :attribute es obligatorio cuando :values está presente.',
    'required_with_all'    => 'El campo :attribute es obligatorio cuando :values está presente.',
    'required_without'     => 'El campo :attribute es obligatorio cuando :values no está presente.',
    'required_without_all' => 'El campo :attribute es obligatorio cuando ningún campo :values están presentes.',
    'same'                 => 'Los campos :attribute y :other deben coincidir.',
    'size'                 => [
        'numeric' => 'El campo :attribute debe ser :size.',
        'file'    => 'El archivo :attribute debe pesar :size kilobytes.',
        'string'  => 'El campo :attribute debe contener :size caracteres.',
        'array'   => 'El campo :attribute debe contener :size elementos.',
    ],
    'state'                => 'El estado no es válido para el país seleccionado.',
    'string'               => 'El campo :attribute debe contener solo caracteres.',
    'timezone'             => 'El campo :attribute debe contener una zona válida.',
    'unique'               => 'El elemento :attribute ya está en uso.',
    'url'                  => 'El formato de :attribute no corresponde con el de una URL válida.',

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
        'attribute-name' => [
            'rule-name' => 'custom-message',
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

        'tipodocumento'    => 'Tipo de Documento',
        'numerodocumento'=> 'Nro de Documento',
        'activo'        => 'Estatus',
        'primernombre'    =>'Primer Nombre',
        'segundonombre'    => 'Segundo Nombre',
        'primerapellido'    => 'Primer Apellido',
        'segundoapellido'    => 'Segundo Apellido',
        'genero'    => 'Género',
        'fechanacimiento'    => 'Fecha de Nacimiento',
        'estadocivil'    => 'Estado Civil',
        'ocupacion'    => 'Ocupación',
        'pais_id'    => 'País de Nacimiento',
        'departamento_id'    => 'Departamento de Nacimiento',
        'municipio_id'    => 'Municipio Nacimiento',
        'paisresidencia_id'    => 'País de Residencia',
        'departamentoresidencia_id'    => 'Departamento de Residencia',
        'municipioresidencia_id'    => 'Municipio Residencia',
        'telefono'    => 'Teléfono',
        'direccion'    => 'Dirección',
        'registro'    => 'Nro. de Registro',
        'imagen'    => 'Imagen de Usuario',
        'firma'    => 'Imagen de Firma',
        'banner' => 'Imagen de banner',
        'descripcion'   => 'Descripción',

        'alergias' => 'Alergias a Medicamentos',
        'ingresos' => 'Ingresos Previos y Cirugias',
        'traumatismos' => 'Traumas y Accidentes',
        'tratamientos' => 'Tratamientos Habituales',
        'hta' => 'HTA',
        'displidemia' => 'Dislipidemia',
        'dm' => 'Diabetes Mellitus',
        'otros' => 'Otros',
        'habitos' => 'Habitos Tóxicos',
        'familiares' => 'Situación Basal (Crónicos)',
        'situacion' => 'Antecedentes familiares de interes',

        'gestante' => 'Gestante', 
        'fum' => 'Fecha de Ultima Menstrución',  
        'seguridad' => 'Seguridad Menstruación', 
        'cesarias' => 'Nro. Cesarias',
        'partos' => 'Nro. Partos',
        'abortos' => 'Nro. Abortos',
        'gestaciones' => 'Nro. Gestaciones',
        'fpp' => 'Fecha Posible de Parto',  

        'motivo_consulta' => 'Motivo de la Consulta',
        'enfermedad_actual' => 'Enfermedad Actual', 

        'peso' => 'Peso', 
        'talla' => 'Talla', 
        'pa' => 'PA', 
        'ta' => 'TA', 
        'fc' => 'FC', 
        'fr' => 'FR', 
        'otros' => 'Otros', 
        'aspectogeneral' => 'Aspecto General', 

        'concepto' => 'Concepto', 
        'tipo_diagnostico_id' => 'Diagnóstico',  
        'procedimientos' => 'Procedimientos',
        'analisis' => 'Análisis',   
        'recomendaciones' => 'Recomendaciones',   

        'descripcion' => 'Descripción', 
        'dosis' => 'Dosis',   
        'Observación' => 'Observación',

        'fechainicial' => 'Fecha de Inicio',  
        'fechafinal' => 'Fecha Final',  
        'observacion' => 'Observación',

        'sacogestacional' => 'Saco Gestacional',  
        'formasaco' => 'Forma de Saco',  
        'visualizacionembrion' => 'Visualización',  
        'numeroembriones' => 'Número de Embriones',
        'actividadmotora' => 'Actividad Motora',  
        'actividadcardiaca' =>'Actividad Cardiaca',  
        'longitud' => 'Longitud Cefalo-Caudal',
        'corionanterior' => 'Anterior',  
        'corionposterior' => 'Posterior',  
        'corioncervix' => 'Cubre el Cervix',  
        'ecocardiagrama' => 'EG Por Ecografía ',
        'observaciones' => 'Observaciones',

        'situacionfetal' =>'Situación Fetal',
        'dorso' =>'Dorso',
        'dbp' =>'DBM', 
        'lf' =>'LF', 
        'pabdominal' =>'P-Abdominal', 
        'actividadmotora' =>'Act. Motora',  
        'actividadcardiaca' =>'Act. Cardíaca',  
        'actividadrespiratoria' =>'Act. Respiratoria',  
        'semanaecografia' =>'Sem. por Ecografía', 
        'localizacion' =>'Localización Placentaria',
        'madurez' =>'Madurez',
        'liquidovolumen' =>'Volumen',
        'liquidoobservaciones' =>'Observaciones',

        'tipo_examen_id' => 'Tipo de Examen',
        'empresa' => 'Empres', 
        'empresa_id' => 'EPS',
        'arl_id' => 'ARL',
        'afp_id' => 'AFP',
        'escolaridad_id' => 'Escolaridad',  
        'numerohijos' => 'Nros de Hijos',
        'numeropersonascargo' => 'Nros de Personas a Cargo',
        'cargoactual' => 'Cargo Actual', 
        'turno_id' => 'Turno',   
        'actividad_id' => 'Actividad',   

        'factor_riesgo_id' => 'Tipo de Riesgo',   
        'otro' => 'Otro',   
        'tiempoexposicion' => 'Tiempo de Exposición',
        'medidacontrol' => 'Medidas de Control',

        'empresa' => 'Empresa', 
        'tiemposervicio' => 'Tiempo de Servicio',   
        'ocupacion' => 'Ocupación',

        'lesion_id' => 'Tipo de Lesión',   
        'otros' => 'Otros',   
        'secuela' => 'Secuela',
        'arl' => 'ARL',

        'fumador' => 'Fumador', 
        'tiempo_fumador_id' => 'Tiempo', 
        'cantidad_fumador_id' => 'Cantidas/días', 

        'bebedor' => 'Bebedor', 
        'tiempo_licor_id' => 'Tiempo', 
        'tiempo_licor2_id' => 'Tiempo', 
        'tipolicor' => 'Tipo de Licor',
        
        'medicamento'=>'Cual?',
        'nombremedicamento'=>'string|max:150',
        'regularidad_medicamento_id'=>'Regularidad',

        'vacuna' => 'Vacuna', 
        'fecha' => 'Fecha',    
        'dosis' => 'Dosis', 

        'enfermedad_id' => 'Enfermedad', 
        'observacion' => 'Observación',   

        'fum' => 'Fecha de Ultima Menstrución', 
        'fuc' => 'Fecha de Ultima Citología',   
        'citologia' => 'Resultado Citología',
        'dismenorrea' => 'Dismenorrea',    
        'gravidez' => 'Nro. de  Gravidez',   
        'partos' => 'Nro. de  Partos',   
        'abortos' => 'Nro. de  Abortos',
        'cesarias' => 'Nro. de  Cesarias',

        'peso' => 'Peso', 
        'talla' => 'Talla', 
        'imc' => 'IMC', 
        'ta' => 'TA', 
        'fc' => 'FC', 
        'fr' => 'FR', 
        'lateralidad_id' => 'Lateralidad',    

        'examen_visual_id' => 'Tipo de Examen', 
        'tipo_condicion_id' => 'Condición', 
        'observacion' => 'Observación',  

        'tipo_examen_altura_id' => 'Tipo de Examen',   
        'observacion' => 'Observación', 

         'examen' => 'Examen', 
        'fecha' => 'Fecha',   
        'resultado' => 'Resultado', 

        'tipo_condicion_id' => 'Condición', 
        'observacion' => 'Observación',  

        'recomendaciones' => 'Recomendaciones', 

    ],

];
