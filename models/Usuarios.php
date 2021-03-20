<?php

namespace app\models;

use yii\web\IdentityInterface;

use Yii;

/**
 * This is the model class for table "usuarios".
 *
 * @property int $id
 * @property string $nombre
 * @property string $password
 * @property string $auth_key
 * @property string $telefono
 * @property string $poblacion
 */
class Usuarios extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'password'], 'required'],
            [['nombre', 'auth_key', 'telefono', 'poblacion'], 'string', 'max' => 255],
            [['password'], 'string', 'max' => 60],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'password' => 'Password',
            'auth_key' => 'Auth Key',
            'telefono' => 'Teléfono',
            'poblacion' => 'Población',
        ];
    }
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }
    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @param null|mixed $type
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
    }
    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        echo $this->id;
        return $this->id;
    }
    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
    }

    /**
     * Devuelve el rol seleccionado.
     * @return string Rol seleccionado
     */
    public function getRol()
    {
        return $this->rol;
    }
    /**
     * @param string $authKey
     * @return bool if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
    }
    /**
     * Validates password.
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($insert && $this->scenario === self::SCENARIO_CREATE) {
            $this->password = Yii::$app->security->generatePasswordHash($this->password);
        }

        return true;
    }

    public function getUsuario()
    {
        return $this->hasOne(self::className(), ['login' => 'login'])->inverseOf('usuarios');
    }


    /**
     * Funcion que me devuelve un usuario buscado.
     *
     * @param  string $login login del usuario
     * @return   Devuelve el usuario.
     */
    public static function lista($login)
    {
        return static::find()
            ->select('login')
            ->where(['login' => $login])
            ->column();
    }
 
}
