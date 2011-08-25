<?php 
	namespace Semdrops\SemdropsMobileBundle\Entity;
 
	use Doctrine\Common\Collections\ArrayCollection;
	use Doctrine\ORM\Mapping as ORM;
	use Symfony\Component\Security\Core\User\UserInterface;
	 
	/**
	 * @ORM\Entity
	 * @ORM\Table(name="user")
	 */
	class User implements UserInterface
	{
	    // ...
	 
	    /**
	     * @ORM\Column(type="string", length="255")
	     *
	     * @var string username
	     */
	    protected $username;
	 
	    /**
	     * @ORM\Column(type="string", length="255")
	     *
	     * @var string password
	     */
	    protected $password;
	 
	    /**
	     * @ORM\Column(type="string", length="255")
	     *
	     * @var string salt
	     */
	    protected $salt;
	 
	    /**
	     * @ORM\ManyToMany(targetEntity="Role")
	     * @ORM\JoinTable(name="user_role",
	     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
	     *     inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
	     * )
	     *
	     * @var ArrayCollection $userRoles
	     */
	    protected $userRoles;
	 
	    // ... 
	 
	    /**
	     * @return string The username.
	     */
	    public function getUsername() {
	        return $this->username;
	    }
	 
	    /**
	     * @param string $value The username.
	     */
	    public function setUsername($value) {
	        $this->username = $value;
	    }
	 
	    /**
	     * @return string The password.
	     */
	    public function getPassword() {
	        return $this->password;
	    }
	 
	    /**
	     * @param string $value The password.
	     */
	    public function setPassword($value) {
	        $this->password = $value;
	    }
	 
	    /**
	     * Gets the user salt.
	     *
	     * @return string The salt.
	     */
	    public function getSalt() {
	        return $this->salt;
	    }
	 
	    /**
	     * Sets the user salt.
	     *
	     * @param string $value The salt.
	     */
	    public function setSalt($value) {
	        $this->salt = $value;
	    }
	 
	    /**
	     * Gets the user roles.
	     *
	     * @return ArrayCollection A Doctrine ArrayCollection
	     */
	    public function getUserRoles() {
	        return $this->userRoles;
	    }
	 
	    /**
	     * Constructs a new instance of User
	     */
	    public function __construct() {
	        $this->posts = new ArrayCollection();
	        $this->userRoles = new ArrayCollection();
	        $this->createdAt = new \DateTime();
	    }
	 
	    /**
	     * Erases the user credentials.
	     */
	    public function eraseCredentials() {
	        $this->setPassword('');
	    }
	 
	    /**
	     * Gets an array of roles.
	     * 
	     * @return array An array of Role objects
	     */
	    public function getRoles() {
	        return $this->getUserRoles()->toArray();
	    }
	 
	    /**
	     * Compares this user to another to determine if they are the same.
	     * 
	     * @param UserInterface $user The user
	     * @return boolean True if equal, false othwerwise.
	     */
	    public function equals(UserInterface $user) {
	        return md5($this->getUsername()) == md5($user->getUsername());
	    }
	 
	}
?>
