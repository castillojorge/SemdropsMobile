<?php  



namespace Symfony\Bundle\FrameworkBundle\EventListener
{

use Symfony\Component\DependencyInjection\ContainerInterface;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;


class SessionListener
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }

        if (!$this->container->has('session')) {
            return;
        }

        $request = $event->getRequest();
        if ($request->hasSession()) {
            return;
        }

        $request->setSession($session = $this->container->get('session'));

        if ($request->hasPreviousSession()) {
            $session->start();
        }
    }
}
}
 



namespace Symfony\Component\HttpFoundation\SessionStorage
{


interface SessionStorageInterface
{
    
    function start();

    
    function getId();

    
    function read($key);

    
    function remove($key);

    
    function write($key, $data);

    
    function regenerate($destroy = false);
}
}
 



namespace Symfony\Component\HttpFoundation
{

use Symfony\Component\HttpFoundation\SessionStorage\SessionStorageInterface;


class Session implements \Serializable
{
    protected $storage;
    protected $started;
    protected $attributes;
    protected $flashes;
    protected $oldFlashes;
    protected $locale;
    protected $defaultLocale;

    
    public function __construct(SessionStorageInterface $storage, $defaultLocale = 'en')
    {
        $this->storage = $storage;
        $this->defaultLocale = $defaultLocale;
        $this->locale = $defaultLocale;
        $this->flashes = array();
        $this->oldFlashes = array();
        $this->attributes = array();
        $this->setPhpDefaultLocale($this->defaultLocale);
        $this->started = false;
    }

    
    public function start()
    {
        if (true === $this->started) {
            return;
        }

        $this->storage->start();

        $attributes = $this->storage->read('_symfony2');

        if (isset($attributes['attributes'])) {
            $this->attributes = $attributes['attributes'];
            $this->flashes = $attributes['flashes'];
            $this->locale = $attributes['locale'];
            $this->setPhpDefaultLocale($this->locale);

                        $this->oldFlashes = $this->flashes;
        }

        $this->started = true;
    }

    
    public function has($name)
    {
        return array_key_exists($name, $this->attributes);
    }

    
    public function get($name, $default = null)
    {
        return array_key_exists($name, $this->attributes) ? $this->attributes[$name] : $default;
    }

    
    public function set($name, $value)
    {
        if (false === $this->started) {
            $this->start();
        }

        $this->attributes[$name] = $value;
    }

    
    public function getAttributes()
    {
        return $this->attributes;
    }

    
    public function setAttributes(array $attributes)
    {
        if (false === $this->started) {
            $this->start();
        }

        $this->attributes = $attributes;
    }

    
    public function remove($name)
    {
        if (false === $this->started) {
            $this->start();
        }

        if (array_key_exists($name, $this->attributes)) {
            unset($this->attributes[$name]);
        }
    }

    
    public function clear()
    {
        if (false === $this->started) {
            $this->start();
        }

        $this->attributes = array();
        $this->flashes = array();
        $this->setPhpDefaultLocale($this->locale = $this->defaultLocale);
    }

    
    public function invalidate()
    {
        $this->clear();
        $this->storage->regenerate();
    }

    
    public function migrate()
    {
        $this->storage->regenerate();
    }

    
    public function getId()
    {
        if (false === $this->started) {
            $this->start();
        }

        return $this->storage->getId();
    }

    
    public function getLocale()
    {
        return $this->locale;
    }

    
    public function setLocale($locale)
    {
        if (false === $this->started) {
            $this->start();
        }

        $this->setPhpDefaultLocale($this->locale = $locale);
    }

    
    public function getFlashes()
    {
        return $this->flashes;
    }

    
    public function setFlashes($values)
    {
        if (false === $this->started) {
            $this->start();
        }

        $this->flashes = $values;
        $this->oldFlashes = array();
    }

    
    public function getFlash($name, $default = null)
    {
        return array_key_exists($name, $this->flashes) ? $this->flashes[$name] : $default;
    }

    
    public function setFlash($name, $value)
    {
        if (false === $this->started) {
            $this->start();
        }

        $this->flashes[$name] = $value;
        unset($this->oldFlashes[$name]);
    }

    
    public function hasFlash($name)
    {
        if (false === $this->started) {
            $this->start();
        }

        return array_key_exists($name, $this->flashes);
    }

    
    public function removeFlash($name)
    {
        if (false === $this->started) {
            $this->start();
        }

        unset($this->flashes[$name]);
    }

    
    public function clearFlashes()
    {
        if (false === $this->started) {
            $this->start();
        }

        $this->flashes = array();
        $this->oldFlashes = array();
    }

    public function save()
    {
        if (false === $this->started) {
            $this->start();
        }

        $this->flashes = array_diff_key($this->flashes, $this->oldFlashes);

        $this->storage->write('_symfony2', array(
            'attributes' => $this->attributes,
            'flashes'    => $this->flashes,
            'locale'     => $this->locale,
        ));
    }

    public function __destruct()
    {
        if (true === $this->started) {
            $this->save();
        }
    }

    public function serialize()
    {
        return serialize(array($this->storage, $this->defaultLocale));
    }

    public function unserialize($serialized)
    {
        list($this->storage, $this->defaultLocale) = unserialize($serialized);
        $this->attributes = array();
        $this->started = false;
    }

    private function setPhpDefaultLocale($locale)
    {
        try {
            \Locale::setDefault($this->locale);
        } catch (\Exception $e) {
                    }
    }
}
}
 



namespace Symfony\Component\HttpFoundation\SessionStorage
{


class NativeSessionStorage implements SessionStorageInterface
{
    static protected $sessionIdRegenerated = false;
    static protected $sessionStarted       = false;

    protected $options;

    
    public function __construct(array $options = array())
    {
        $cookieDefaults = session_get_cookie_params();

        $this->options = array_merge(array(
            'lifetime' => $cookieDefaults['lifetime'],
            'path'     => $cookieDefaults['path'],
            'domain'   => $cookieDefaults['domain'],
            'secure'   => $cookieDefaults['secure'],
            'httponly' => isset($cookieDefaults['httponly']) ? $cookieDefaults['httponly'] : false,
        ), $options);

                if (isset($this->options['name'])) {
            session_name($this->options['name']);
        }
    }

    
    public function start()
    {
        if (self::$sessionStarted) {
            return;
        }

        session_set_cookie_params(
            $this->options['lifetime'],
            $this->options['path'],
            $this->options['domain'],
            $this->options['secure'],
            $this->options['httponly']
        );

                session_cache_limiter(false);

        if (!ini_get('session.use_cookies') && isset($this->options['id']) && $this->options['id'] && $this->options['id'] != session_id()) {
            session_id($this->options['id']);
        }

        session_start();

        self::$sessionStarted = true;
    }

    
    public function getId()
    {
        if (!self::$sessionStarted) {
            throw new \RuntimeException('The session must be started before reading its ID');
        }

        return session_id();
    }

    
    public function read($key, $default = null)
    {
        return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : $default;
    }

    
    public function remove($key)
    {
        $retval = null;

        if (isset($_SESSION[$key])) {
            $retval = $_SESSION[$key];
            unset($_SESSION[$key]);
        }

        return $retval;
    }

    
    public function write($key, $data)
    {
        $_SESSION[$key] = $data;
    }

    
    public function regenerate($destroy = false)
    {
        if (self::$sessionIdRegenerated) {
            return;
        }

        session_regenerate_id($destroy);

        self::$sessionIdRegenerated = true;
    }
}
}
 



namespace Symfony\Component\Routing\Matcher
{

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RequestContext;


class UrlMatcher implements UrlMatcherInterface
{
    protected $context;

    private $routes;

    
    public function __construct(RouteCollection $routes, RequestContext $context)
    {
        $this->routes = $routes;
        $this->context = $context;
    }

    
    public function setContext(RequestContext $context)
    {
        $this->context = $context;
    }

    
    public function getContext()
    {
        return $this->context;
    }

    
    public function match($pathinfo)
    {
        $this->allow = array();

        if ($ret = $this->matchCollection($pathinfo, $this->routes)) {
            return $ret;
        }

        throw 0 < count($this->allow)
            ? new MethodNotAllowedException(array_unique(array_map('strtoupper', $this->allow)))
            : new ResourceNotFoundException();
    }

    protected function matchCollection($pathinfo, RouteCollection $routes)
    {
        $pathinfo = urldecode($pathinfo);

        foreach ($routes as $name => $route) {
            if ($route instanceof RouteCollection) {
                if (false === strpos($route->getPrefix(), '{') && $route->getPrefix() !== substr($pathinfo, 0, strlen($route->getPrefix()))) {
                    continue;
                }

                if (!$ret = $this->matchCollection($pathinfo, $route)) {
                    continue;
                }

                return $ret;
            }

            $compiledRoute = $route->compile();

                        if ('' !== $compiledRoute->getStaticPrefix() && 0 !== strpos($pathinfo, $compiledRoute->getStaticPrefix())) {
                continue;
            }

            if (!preg_match($compiledRoute->getRegex(), $pathinfo, $matches)) {
                continue;
            }

                        if ($req = $route->getRequirement('_method')) {
                                if ('HEAD' === $method = $this->context->getMethod()) {
                    $method = 'GET';
                }

                if (!in_array($method, $req = explode('|', strtoupper($req)))) {
                    $this->allow = array_merge($this->allow, $req);

                    continue;
                }
            }

            return array_merge($this->mergeDefaults($matches, $route->getDefaults()), array('_route' => $name));
        }
    }

    protected function mergeDefaults($params, $defaults)
    {
        $parameters = $defaults;
        foreach ($params as $key => $value) {
            if (!is_int($key)) {
                $parameters[$key] = rawurldecode($value);
            }
        }

        return $parameters;
    }
}
}
 



namespace Symfony\Component\Routing\Generator
{

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Exception\InvalidParameterException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\Exception\MissingMandatoryParametersException;


class UrlGenerator implements UrlGeneratorInterface
{
    protected $context;

    private $routes;
    private $cache;

    
    public function __construct(RouteCollection $routes, RequestContext $context)
    {
        $this->routes = $routes;
        $this->context = $context;
        $this->cache = array();
    }

    
    public function setContext(RequestContext $context)
    {
        $this->context = $context;
    }

    
    public function getContext()
    {
        return $this->context;
    }

    
    public function generate($name, array $parameters = array(), $absolute = false)
    {
        if (null === $route = $this->routes->get($name)) {
            throw new RouteNotFoundException(sprintf('Route "%s" does not exist.', $name));
        }

        if (!isset($this->cache[$name])) {
            $this->cache[$name] = $route->compile();
        }

        return $this->doGenerate($this->cache[$name]->getVariables(), $route->getDefaults(), $route->getRequirements(), $this->cache[$name]->getTokens(), $parameters, $name, $absolute);
    }

    
    protected function doGenerate($variables, $defaults, $requirements, $tokens, $parameters, $name, $absolute)
    {
        $variables = array_flip($variables);

        $originParameters = $parameters;
        $parameters = array_replace($this->context->getParameters(), $parameters);
        $tparams = array_replace($defaults, $parameters);

                if ($diff = array_diff_key($variables, $tparams)) {
            throw new MissingMandatoryParametersException(sprintf('The "%s" route has some missing mandatory parameters ("%s").', $name, implode('", "', array_keys($diff))));
        }

        $url = '';
        $optional = true;
        foreach ($tokens as $token) {
            if ('variable' === $token[0]) {
                if (false === $optional || !array_key_exists($token[3], $defaults) || (isset($parameters[$token[3]]) && $parameters[$token[3]] != $defaults[$token[3]])) {
                    if (!$isEmpty = in_array($tparams[$token[3]], array(null, '', false), true)) {
                                                if ($tparams[$token[3]] && !preg_match('#^'.$token[2].'$#', $tparams[$token[3]])) {
                            throw new InvalidParameterException(sprintf('Parameter "%s" for route "%s" must match "%s" ("%s" given).', $token[3], $name, $token[2], $tparams[$token[3]]));
                        }
                    }

                    if (!$isEmpty || !$optional) {
                        $url = $token[1].strtr($tparams[$token[3]], array('%'=>'%25', '+'=>'%2B')).$url;
                    }

                    $optional = false;
                }
            } elseif ('text' === $token[0]) {
                $url = $token[1].$url;
                $optional = false;
            }
        }

        if (!$url) {
            $url = '/';
        }

                if ($extra = array_diff_key($originParameters, $variables, $defaults)) {
            $url .= '?'.http_build_query($extra);
        }

        $url = $this->context->getBaseUrl().$url;

        if ($this->context->getHost()) {
            $scheme = $this->context->getScheme();
            if (isset($requirements['_scheme']) && ($req = strtolower($requirements['_scheme'])) && $scheme != $req) {
                $absolute = true;
                $scheme = $req;
            }

            if ($absolute) {
                $port = '';
                if ('http' === $scheme && 80 != $this->context->getHttpPort()) {
                    $port = ':'.$this->context->getHttpPort();
                } elseif ('https' === $scheme && 443 != $this->context->getHttpsPort()) {
                    $port = ':'.$this->context->getHttpsPort();
                }

                $url = $scheme.'://'.$this->context->getHost().$port.$url;
            }
        }

        return $url;
    }
}
}
 



namespace Symfony\Bundle\FrameworkBundle\Templating
{

use Symfony\Component\Templating\EngineInterface as BaseEngineInterface;
use Symfony\Component\HttpFoundation\Response;


interface EngineInterface extends BaseEngineInterface
{
    
    function renderResponse($view, array $parameters = array(), Response $response = null);
}
}
 



namespace Symfony\Component\Templating
{


interface EngineInterface
{
    
    function render($name, array $parameters = array());

    
    function exists($name);

    
    function supports($name);
}
}
 



namespace Symfony\Component\Templating
{


interface TemplateReferenceInterface
{
    
    function all();

    
    function set($name, $value);

    
    function get($name);

    
    function getPath();

    
    function getLogicalName();
}
}
 



namespace Symfony\Component\Templating
{


class TemplateReference implements TemplateReferenceInterface
{
    protected $parameters;

    public function __construct($name = null, $engine = null)
    {
        $this->parameters = array(
            'name'   => $name,
            'engine' => $engine,
        );
    }

    public function __toString()
    {
        return $this->getLogicalName();
    }

    
    public function set($name, $value)
    {
        if (array_key_exists($name, $this->parameters)) {
            $this->parameters[$name] = $value;
        } else {
            throw new \InvalidArgumentException(sprintf('The template does not support the "%s" parameter.', $name));
        }

        return $this;
    }

    
    public function get($name)
    {
        if (array_key_exists($name, $this->parameters)) {
            return $this->parameters[$name];
        }

        throw new \InvalidArgumentException(sprintf('The template does not support the "%s" parameter.', $name));
    }

    
    public function all()
    {
        return $this->parameters;
    }

    
    public function getPath()
    {
        return $this->parameters['name'];
    }

    
    public function getLogicalName()
    {
        return $this->parameters['name'];
    }
}
}
 



namespace Symfony\Bundle\FrameworkBundle\Templating
{

use Symfony\Component\Templating\TemplateReference as BaseTemplateReference;


class TemplateReference extends BaseTemplateReference
{
    public function __construct($bundle = null, $controller = null, $name = null, $format = null, $engine = null)
    {
        $this->parameters = array(
            'bundle'     => $bundle,
            'controller' => $controller,
            'name'       => $name,
            'format'     => $format,
            'engine'     => $engine,
        );
    }

    
    public function getPath()
    {
        $controller = str_replace('\\', '/', $this->get('controller'));

        $path = (empty($controller) ? '' : $controller.'/').$this->get('name').'.'.$this->get('format').'.'.$this->get('engine');

        return empty($this->parameters['bundle']) ? 'views/'.$path : '@'.$this->get('bundle').'/Resources/views/'.$path;
    }

    
    public function getLogicalName()
    {
        return sprintf('%s:%s:%s.%s.%s', $this->get('bundle'), $this->get('controller'), $this->get('name'), $this->get('format'), $this->get('engine'));
    }
}
}
 



namespace Symfony\Component\HttpFoundation
{


class Response
{
    
    public $headers;

    protected $content;
    protected $version;
    protected $statusCode;
    protected $statusText;
    protected $charset;

    static public $statusTexts = array(
        100 => 'Continue',
        101 => 'Switching Protocols',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        307 => 'Temporary Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
    );

    
    public function __construct($content = '', $status = 200, $headers = array())
    {
        $this->headers = new ResponseHeaderBag($headers);
        $this->setContent($content);
        $this->setStatusCode($status);
        $this->setProtocolVersion('1.0');
        if (!$this->headers->has('Date')) {
            $this->setDate(new \DateTime(null, new \DateTimeZone('UTC')));
        }
    }

    
    public function __toString()
    {
        $this->fixContentType();

        return
            sprintf('HTTP/%s %s %s', $this->version, $this->statusCode, $this->statusText)."\r\n".
            $this->headers."\r\n".
            $this->getContent();
    }

    
    public function __clone()
    {
        $this->headers = clone $this->headers;
    }

    
    public function sendHeaders()
    {
        $this->fixContentType();

                header(sprintf('HTTP/%s %s %s', $this->version, $this->statusCode, $this->statusText));

                foreach ($this->headers->all() as $name => $values) {
            foreach ($values as $value) {
                header($name.': '.$value, false);
            }
        }

                foreach ($this->headers->getCookies() as $cookie) {
            setcookie($cookie->getName(), $cookie->getValue(), $cookie->getExpiresTime(), $cookie->getPath(), $cookie->getDomain(), $cookie->isSecure(), $cookie->isHttpOnly());
        }
    }

    
    public function sendContent()
    {
        echo $this->content;
    }

    
    public function send()
    {
        $this->sendHeaders();
        $this->sendContent();

        if (function_exists('fastcgi_finish_request')) {
            fastcgi_finish_request();
        }
    }

    
    public function setContent($content)
    {
        if (null !== $content && !is_string($content) && !is_numeric($content) && !is_callable(array($content, '__toString'))) {
            throw new \UnexpectedValueException('The Response content must be a string or object implementing __toString(), "'.gettype($content).'" given.');
        }

        $this->content = (string) $content;
    }

    
    public function getContent()
    {
        return $this->content;
    }

    
    public function setProtocolVersion($version)
    {
        $this->version = $version;
    }

    
    public function getProtocolVersion()
    {
        return $this->version;
    }

    
    public function setStatusCode($code, $text = null)
    {
        $this->statusCode = (int) $code;
        if ($this->isInvalid()) {
            throw new \InvalidArgumentException(sprintf('The HTTP status code "%s" is not valid.', $code));
        }

        $this->statusText = false === $text ? '' : (null === $text ? self::$statusTexts[$this->statusCode] : $text);
    }

    
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    
    public function setCharset($charset)
    {
        $this->charset = $charset;
    }

    
    public function getCharset()
    {
        return $this->charset;
    }

    
    public function isCacheable()
    {
        if (!in_array($this->statusCode, array(200, 203, 300, 301, 302, 404, 410))) {
            return false;
        }

        if ($this->headers->hasCacheControlDirective('no-store') || $this->headers->getCacheControlDirective('private')) {
            return false;
        }

        return $this->isValidateable() || $this->isFresh();
    }

    
    public function isFresh()
    {
        return $this->getTtl() > 0;
    }

    
    public function isValidateable()
    {
        return $this->headers->has('Last-Modified') || $this->headers->has('ETag');
    }

    
    public function setPrivate()
    {
        $this->headers->removeCacheControlDirective('public');
        $this->headers->addCacheControlDirective('private');
    }

    
    public function setPublic()
    {
        $this->headers->addCacheControlDirective('public');
        $this->headers->removeCacheControlDirective('private');
    }

    
    public function mustRevalidate()
    {
        return $this->headers->hasCacheControlDirective('must-revalidate') || $this->headers->has('must-proxy-revalidate');
    }

    
    public function getDate()
    {
        return $this->headers->getDate('Date');
    }

    
    public function setDate(\DateTime $date)
    {
        $date->setTimezone(new \DateTimeZone('UTC'));
        $this->headers->set('Date', $date->format('D, d M Y H:i:s').' GMT');
    }

    
    public function getAge()
    {
        if ($age = $this->headers->get('Age')) {
            return $age;
        }

        return max(time() - $this->getDate()->format('U'), 0);
    }

    
    public function expire()
    {
        if ($this->isFresh()) {
            $this->headers->set('Age', $this->getMaxAge());
        }
    }

    
    public function getExpires()
    {
        return $this->headers->getDate('Expires');
    }

    
    public function setExpires(\DateTime $date = null)
    {
        if (null === $date) {
            $this->headers->remove('Expires');
        } else {
            $date = clone $date;
            $date->setTimezone(new \DateTimeZone('UTC'));
            $this->headers->set('Expires', $date->format('D, d M Y H:i:s').' GMT');
        }
    }

    
    public function getMaxAge()
    {
        if ($age = $this->headers->getCacheControlDirective('s-maxage')) {
            return $age;
        }

        if ($age = $this->headers->getCacheControlDirective('max-age')) {
            return $age;
        }

        if (null !== $this->getExpires()) {
            return $this->getExpires()->format('U') - $this->getDate()->format('U');
        }

        return null;
    }

    
    public function setMaxAge($value)
    {
        $this->headers->addCacheControlDirective('max-age', $value);
    }

    
    public function setSharedMaxAge($value)
    {
        $this->setPublic();
        $this->headers->addCacheControlDirective('s-maxage', $value);
    }

    
    public function getTtl()
    {
        if ($maxAge = $this->getMaxAge()) {
            return $maxAge - $this->getAge();
        }

        return null;
    }

    
    public function setTtl($seconds)
    {
        $this->setSharedMaxAge($this->getAge() + $seconds);
    }

    
    public function setClientTtl($seconds)
    {
        $this->setMaxAge($this->getAge() + $seconds);
    }

    
    public function getLastModified()
    {
        return $this->headers->getDate('Last-Modified');
    }

    
    public function setLastModified(\DateTime $date = null)
    {
        if (null === $date) {
            $this->headers->remove('Last-Modified');
        } else {
            $date = clone $date;
            $date->setTimezone(new \DateTimeZone('UTC'));
            $this->headers->set('Last-Modified', $date->format('D, d M Y H:i:s').' GMT');
        }
    }

    
    public function getEtag()
    {
        return $this->headers->get('ETag');
    }

    
    public function setEtag($etag = null, $weak = false)
    {
        if (null === $etag) {
            $this->headers->remove('Etag');
        } else {
            if (0 !== strpos($etag, '"')) {
                $etag = '"'.$etag.'"';
            }

            $this->headers->set('ETag', (true === $weak ? 'W/' : '').$etag);
        }
    }

    
    public function setCache(array $options)
    {
        if ($diff = array_diff(array_keys($options), array('etag', 'last_modified', 'max_age', 's_maxage', 'private', 'public'))) {
            throw new \InvalidArgumentException(sprintf('Response does not support the following options: "%s".', implode('", "', array_keys($diff))));
        }

        if (isset($options['etag'])) {
            $this->setEtag($options['etag']);
        }

        if (isset($options['last_modified'])) {
            $this->setLastModified($options['last_modified']);
        }

        if (isset($options['max_age'])) {
            $this->setMaxAge($options['max_age']);
        }

        if (isset($options['s_maxage'])) {
            $this->setSharedMaxAge($options['s_maxage']);
        }

        if (isset($options['public'])) {
            if ($options['public']) {
                $this->setPublic();
            } else {
                $this->setPrivate();
            }
        }

        if (isset($options['private'])) {
            if ($options['private']) {
                $this->setPrivate();
            } else {
                $this->setPublic();
            }
        }
    }

    
    public function setNotModified()
    {
        $this->setStatusCode(304);
        $this->setContent(null);

                foreach (array('Allow', 'Content-Encoding', 'Content-Language', 'Content-Length', 'Content-MD5', 'Content-Type', 'Last-Modified') as $header) {
            $this->headers->remove($header);
        }
    }

    
    public function hasVary()
    {
        return (Boolean) $this->headers->get('Vary');
    }

    
    public function getVary()
    {
        if (!$vary = $this->headers->get('Vary')) {
            return array();
        }

        return is_array($vary) ? $vary : preg_split('/[\s,]+/', $vary);
    }

    
    public function setVary($headers, $replace = true)
    {
        $this->headers->set('Vary', $headers, $replace);
    }

    
    public function isNotModified(Request $request)
    {
        $lastModified = $request->headers->get('If-Modified-Since');
        $notModified = false;
        if ($etags = $request->getEtags()) {
            $notModified = (in_array($this->getEtag(), $etags) || in_array('*', $etags)) && (!$lastModified || $this->headers->get('Last-Modified') == $lastModified);
        } elseif ($lastModified) {
            $notModified = $lastModified == $this->headers->get('Last-Modified');
        }

        if ($notModified) {
            $this->setNotModified();
        }

        return $notModified;
    }

        public function isInvalid()
    {
        return $this->statusCode < 100 || $this->statusCode >= 600;
    }

    public function isInformational()
    {
        return $this->statusCode >= 100 && $this->statusCode < 200;
    }

    public function isSuccessful()
    {
        return $this->statusCode >= 200 && $this->statusCode < 300;
    }

    public function isRedirection()
    {
        return $this->statusCode >= 300 && $this->statusCode < 400;
    }

    public function isClientError()
    {
        return $this->statusCode >= 400 && $this->statusCode < 500;
    }

    public function isServerError()
    {
        return $this->statusCode >= 500 && $this->statusCode < 600;
    }

    public function isOk()
    {
        return 200 === $this->statusCode;
    }

    public function isForbidden()
    {
        return 403 === $this->statusCode;
    }

    public function isNotFound()
    {
        return 404 === $this->statusCode;
    }

    public function isRedirect($location = null)
    {
        return in_array($this->statusCode, array(201, 301, 302, 303, 307)) && (null === $location ?: $location == $this->headers->get('Location'));
    }

    public function isEmpty()
    {
        return in_array($this->statusCode, array(201, 204, 304));
    }

    protected function fixContentType()
    {
        $charset = $this->charset ?: 'UTF-8';
        if (!$this->headers->has('Content-Type')) {
            $this->headers->set('Content-Type', 'text/html; charset='.$charset);
        } elseif ('text/' === substr($this->headers->get('Content-Type'), 0, 5) && false === strpos($this->headers->get('Content-Type'), 'charset')) {
                        $this->headers->set('Content-Type', $this->headers->get('Content-Type').'; charset='.$charset);
        }
    }
}
}
 



namespace Symfony\Component\HttpFoundation
{


class ResponseHeaderBag extends HeaderBag
{
    protected $computedCacheControl = array();

    
    public function __construct(array $headers = array())
    {
        parent::__construct($headers);

        if (!isset($this->headers['cache-control'])) {
            $this->set('cache-control', '');
        }
    }

    
    public function __toString()
    {
        $cookies = '';
        foreach ($this->cookies as $cookie) {
            $cookies .= 'Set-Cookie: '.$cookie."\r\n";
        }

        return parent::__toString().$cookies;
    }

    
    public function replace(array $headers = array())
    {
        parent::replace($headers);

        if (!isset($this->headers['cache-control'])) {
            $this->set('cache-control', '');
        }
    }

    
    public function set($key, $values, $replace = true)
    {
        parent::set($key, $values, $replace);

                if (in_array(strtr(strtolower($key), '_', '-'), array('cache-control', 'etag', 'last-modified', 'expires'))) {
            $computed = $this->computeCacheControlValue();
            $this->headers['cache-control'] = array($computed);
            $this->computedCacheControl = $this->parseCacheControl($computed);
        }
    }

    
    public function remove($key)
    {
        parent::remove($key);

        if ('cache-control' === strtr(strtolower($key), '_', '-')) {
            $this->computedCacheControl = array();
        }
    }

    
    public function hasCacheControlDirective($key)
    {
        return array_key_exists($key, $this->computedCacheControl);
    }

    
    public function getCacheControlDirective($key)
    {
        return array_key_exists($key, $this->computedCacheControl) ? $this->computedCacheControl[$key] : null;
    }

    
    public function clearCookie($name, $path = null, $domain = null)
    {
        $this->setCookie(new Cookie($name, null, 1, $path, $domain));
    }

    
    protected function computeCacheControlValue()
    {
        if (!$this->cacheControl && !$this->has('ETag') && !$this->has('Last-Modified') && !$this->has('Expires')) {
            return 'no-cache';
        }

        if (!$this->cacheControl) {
                        return 'private, must-revalidate';
        }

        $header = $this->getCacheControlHeader();
        if (isset($this->cacheControl['public']) || isset($this->cacheControl['private'])) {
            return $header;
        }

                if (!isset($this->cacheControl['s-maxage'])) {
            return $header.', private';
        }

        return $header;
    }
}
}
 



namespace Symfony\Component\EventDispatcher
{


interface EventDispatcherInterface
{
    
    function dispatch($eventName, Event $event = null);

    
    function addListener($eventName, $listener, $priority = 0);

    
    function addSubscriber(EventSubscriberInterface $subscriber);

    
    function removeListener($eventName, $listener);

    
    function removeSubscriber(EventSubscriberInterface $subscriber);

    
    function getListeners($eventName = null);

    
    function hasListeners($eventName = null);
}
}
 



namespace Symfony\Component\EventDispatcher
{


class EventDispatcher implements EventDispatcherInterface
{
    private $listeners = array();
    private $sorted = array();

    
    public function dispatch($eventName, Event $event = null)
    {
        if (!isset($this->listeners[$eventName])) {
            return;
        }

        if (null === $event) {
            $event = new Event();
        }

        $this->doDispatch($this->getListeners($eventName), $eventName, $event);
    }

    
    public function getListeners($eventName = null)
    {
        if (null !== $eventName) {
            if (!isset($this->sorted[$eventName])) {
                $this->sortListeners($eventName);
            }

            return $this->sorted[$eventName];
        }

        foreach (array_keys($this->listeners) as $eventName) {
            if (!isset($this->sorted[$eventName])) {
                $this->sortListeners($eventName);
            }

            if ($this->sorted[$eventName]) {
                $sorted[$eventName] = $this->sorted[$eventName];
            }
        }

        return $this->sorted;
    }

    
    public function hasListeners($eventName = null)
    {
        return (Boolean) count($this->getListeners($eventName));
    }

    
    public function addListener($eventName, $listener, $priority = 0)
    {
        $this->listeners[$eventName][$priority][] = $listener;
        unset($this->sorted[$eventName]);
    }

    
    public function removeListener($eventName, $listener)
    {
        if (!isset($this->listeners[$eventName])) {
            return;
        }

        foreach ($this->listeners[$eventName] as $priority => $listeners) {
            if (false !== ($key = array_search($listener, $listeners))) {
                unset($this->listeners[$eventName][$priority][$key], $this->sorted[$eventName]);
            }
        }
    }

    
    public function addSubscriber(EventSubscriberInterface $subscriber)
    {
        foreach ($subscriber->getSubscribedEvents() as $eventName => $params) {
            if (is_string($params)) {
                $this->addListener($eventName, array($subscriber, $params));
            } else {
                $this->addListener($eventName, array($subscriber, $params[0]), $params[1]);
            }
        }
    }

    
    public function removeSubscriber(EventSubscriberInterface $subscriber)
    {
        foreach ($subscriber->getSubscribedEvents() as $eventName => $method) {
            $this->removeListener($eventName, array($subscriber, $method));
        }
    }

    
    protected function doDispatch($listeners, $eventName, Event $event)
    {
        foreach ($listeners as $listener) {
            call_user_func($listener, $event);
            if ($event->isPropagationStopped()) {
                break;
            }
        }
    }

    
    private function sortListeners($eventName)
    {
        $this->sorted[$eventName] = array();

        if (isset($this->listeners[$eventName])) {
            krsort($this->listeners[$eventName]);
            $this->sorted[$eventName] = call_user_func_array('array_merge', $this->listeners[$eventName]);
        }
    }
}
}
 



namespace Symfony\Component\EventDispatcher
{


class Event
{
    
    private $propagationStopped = false;

    
    public function isPropagationStopped()
    {
        return $this->propagationStopped;
    }

    
    public function stopPropagation()
    {
        $this->propagationStopped = true;
    }
}
}
 



namespace Symfony\Component\EventDispatcher
{


interface EventSubscriberInterface
{
    
    static function getSubscribedEvents();
}
}
 



namespace Symfony\Component\HttpKernel\EventListener
{

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;


class ResponseListener
{
    private $charset;

    public function __construct($charset)
    {
        $this->charset = $charset;
    }

    
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $request = $event->getRequest();
        $response = $event->getResponse();

        if ('HEAD' === $request->getMethod()) {
            $response->setContent('');
        }

        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }

        if (null === $response->getCharset()) {
            $response->setCharset($this->charset);
        }

        if ($response->headers->has('Content-Type')) {
            return;
        }

        $format = $request->getRequestFormat();
        if ((null !== $format) && $mimeType = $request->getMimeType($format)) {
            $response->headers->set('Content-Type', $mimeType);
        }
    }
}
}
 



namespace Symfony\Component\HttpKernel\Controller
{

use Symfony\Component\HttpKernel\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;


class ControllerResolver implements ControllerResolverInterface
{
    private $logger;

    
    public function __construct(LoggerInterface $logger = null)
    {
        $this->logger = $logger;
    }

    
    public function getController(Request $request)
    {
        if (!$controller = $request->attributes->get('_controller')) {
            if (null !== $this->logger) {
                $this->logger->warn('Unable to look for the controller as the "_controller" parameter is missing');
            }

            return false;
        }

        if (is_array($controller) || ((is_object($controller) || false === strpos($controller, ':')) && method_exists($controller, '__invoke'))) {
            return $controller;
        }

        list($controller, $method) = $this->createController($controller);

        if (!method_exists($controller, $method)) {
            throw new \InvalidArgumentException(sprintf('Method "%s::%s" does not exist.', get_class($controller), $method));
        }

        return array($controller, $method);
    }

    
    public function getArguments(Request $request, $controller)
    {
        $attributes = $request->attributes->all();

        if (is_array($controller)) {
            $r = new \ReflectionMethod($controller[0], $controller[1]);
            $repr = sprintf('%s::%s()', get_class($controller[0]), $controller[1]);
        } elseif (is_object($controller)) {
            $r = new \ReflectionObject($controller);
            $r = $r->getMethod('__invoke');
            $repr = get_class($controller);
        } else {
            $r = new \ReflectionFunction($controller);
            $repr = $controller;
        }

        $arguments = array();
        foreach ($r->getParameters() as $param) {
            if (array_key_exists($param->getName(), $attributes)) {
                $arguments[] = $attributes[$param->getName()];
            } elseif ($param->getClass() && $param->getClass()->isInstance($request)) {
                $arguments[] = $request;
            } elseif ($param->isDefaultValueAvailable()) {
                $arguments[] = $param->getDefaultValue();
            } else {
                throw new \RuntimeException(sprintf('Controller "%s" requires that you provide a value for the "$%s" argument (because there is no default value or because there is a non optional argument after this one).', $repr, $param->getName()));
            }
        }

        return $arguments;
    }

    
    protected function createController($controller)
    {
        if (false === strpos($controller, '::')) {
            throw new \InvalidArgumentException(sprintf('Unable to find controller "%s".', $controller));
        }

        list($class, $method) = explode('::', $controller);

        if (!class_exists($class)) {
            throw new \InvalidArgumentException(sprintf('Class "%s" does not exist.', $class));
        }

        return array(new $class(), $method);
    }
}
}
 



namespace Symfony\Component\HttpKernel\Controller
{

use Symfony\Component\HttpFoundation\Request;


interface ControllerResolverInterface
{
    
    function getController(Request $request);

    
    function getArguments(Request $request, $controller);
}
}
 



namespace Symfony\Component\HttpKernel\Event
{

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\EventDispatcher\Event;


class KernelEvent extends Event
{
    
    private $kernel;

    
    private $request;

    
    private $requestType;

    public function __construct(HttpKernelInterface $kernel, Request $request, $requestType)
    {
        $this->kernel = $kernel;
        $this->request = $request;
        $this->requestType = $requestType;
    }

    
    public function getKernel()
    {
        return $this->kernel;
    }

    
    public function getRequest()
    {
        return $this->request;
    }

    
    public function getRequestType()
    {
        return $this->requestType;
    }
}
}
 



namespace Symfony\Component\HttpKernel\Event
{

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\Request;


class FilterControllerEvent extends KernelEvent
{
    
    private $controller;

    public function __construct(HttpKernelInterface $kernel, $controller, Request $request, $requestType)
    {
        parent::__construct($kernel, $request, $requestType);

        $this->setController($controller);
    }

    
    public function getController()
    {
        return $this->controller;
    }

    
    public function setController($controller)
    {
                if (!is_callable($controller)) {
            throw new \LogicException(sprintf('The controller must be a callable (%s given).', $this->varToString($controller)));
        }

        $this->controller = $controller;
    }

    private function varToString($var)
    {
        if (is_object($var)) {
            return sprintf('Object(%s)', get_class($var));
        }

        if (is_array($var)) {
            $a = array();
            foreach ($var as $k => $v) {
                $a[] = sprintf('%s => %s', $k, $this->varToString($v));
            }

            return sprintf("Array(%s)", implode(', ', $a));
        }

        if (is_resource($var)) {
            return sprintf('Resource(%s)', get_resource_type($var));
        }

        if (null === $var) {
            return 'null';
        }

        if (false === $var) {
            return 'false';
        }

        if (true === $var) {
            return 'true';
        }

        return (string) $var;
    }
}
}
 



namespace Symfony\Component\HttpKernel\Event
{

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class FilterResponseEvent extends KernelEvent
{
    
    private $response;

    public function __construct(HttpKernelInterface $kernel, Request $request, $requestType, Response $response)
    {
        parent::__construct($kernel, $request, $requestType);

        $this->setResponse($response);
    }

    
    public function getResponse()
    {
        return $this->response;
    }

    
    public function setResponse(Response $response)
    {
        $this->response = $response;
    }
}
}
 



namespace Symfony\Component\HttpKernel\Event
{

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class GetResponseEvent extends KernelEvent
{
    
    private $response;

    
    public function getResponse()
    {
        return $this->response;
    }

    
    public function setResponse(Response $response)
    {
        $this->response = $response;

        $this->stopPropagation();
    }

    
    public function hasResponse()
    {
        return null !== $this->response;
    }
}
}
 



namespace Symfony\Component\HttpKernel\Event
{

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\Request;


class GetResponseForControllerResultEvent extends GetResponseEvent
{
    
    private $controllerResult;

    public function __construct(HttpKernelInterface $kernel, Request $request, $requestType, $controllerResult)
    {
        parent::__construct($kernel, $request, $requestType);

        $this->controllerResult = $controllerResult;
    }

    
    public function getControllerResult()
    {
        return $this->controllerResult;
    }
}
}
 



namespace Symfony\Component\HttpKernel\Event
{

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\Request;


class GetResponseForExceptionEvent extends GetResponseEvent
{
    
    private $exception;

    public function __construct(HttpKernelInterface $kernel, Request $request, $requestType, \Exception $e)
    {
        parent::__construct($kernel, $request, $requestType);

        $this->setException($e);
    }

    
    public function getException()
    {
        return $this->exception;
    }

    
    public function setException(\Exception $exception)
    {
        $this->exception = $exception;
    }
}
}
 



namespace Symfony\Component\HttpKernel
{


final class KernelEvents
{
    
    const REQUEST = 'kernel.request';

    
    const EXCEPTION = 'kernel.exception';

    
    const VIEW = 'kernel.view';

    
    const CONTROLLER = 'kernel.controller';

    
    const RESPONSE = 'kernel.response';
}
}
 



namespace Symfony\Bundle\FrameworkBundle\EventListener
{

use Symfony\Component\HttpKernel\Log\LoggerInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Routing\RequestContext;


class RouterListener
{
    private $router;
    private $logger;
    private $httpPort;
    private $httpsPort;

    public function __construct(RouterInterface $router, $httpPort = 80, $httpsPort = 443, LoggerInterface $logger = null)
    {
        $this->router = $router;
        $this->httpPort = $httpPort;
        $this->httpsPort = $httpsPort;
        $this->logger = $logger;
    }

    public function onEarlyKernelRequest(GetResponseEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }

        $request = $event->getRequest();

                        $context = new RequestContext(
            $request->getBaseUrl(),
            $request->getMethod(),
            $request->getHost(),
            $request->getScheme(),
            $request->isSecure() ? $this->httpPort : $request->getPort(),
            $request->isSecure() ? $request->getPort() : $this->httpsPort
        );

        $this->router->setContext($context);
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if ($request->attributes->has('_controller')) {
                        return;
        }

                try {
            $parameters = $this->router->match($request->getPathInfo());

            if (null !== $this->logger) {
                $this->logger->info(sprintf('Matched route "%s" (parameters: %s)', $parameters['_route'], $this->parametersToString($parameters)));
            }

            $request->attributes->add($parameters);
        } catch (ResourceNotFoundException $e) {
            $message = sprintf('No route found for "%s %s"', $request->getMethod(), $request->getPathInfo());

            throw new NotFoundHttpException($message, $e);
        } catch (MethodNotAllowedException $e) {
            $message = sprintf('No route found for "%s %s": Method Not Allowed (Allow: %s)', $request->getMethod(), $request->getPathInfo(), strtoupper(implode(', ', $e->getAllowedMethods())));

            throw new MethodNotAllowedHttpException($e->getAllowedMethods(), $message, $e);
        }

        if (HttpKernelInterface::MASTER_REQUEST === $event->getRequestType()) {
            $context = $this->router->getContext();
            $session = $request->getSession();
            if ($locale = $request->attributes->get('_locale')) {
                if ($session) {
                    $session->setLocale($locale);
                }
                $context->setParameter('_locale', $locale);
            } elseif ($session) {
                $context->setParameter('_locale', $session->getLocale());
            }
        }
    }

    private function parametersToString(array $parameters)
    {
        $pieces = array();
        foreach ($parameters as $key => $val) {
            $pieces[] = sprintf('"%s": "%s"', $key, (is_string($val) ? $val : json_encode($val)));
        }

        return implode(', ', $pieces);
    }
}
}
 



namespace Symfony\Bundle\FrameworkBundle\Controller
{

use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\HttpKernel\Log\LoggerInterface;


class ControllerNameParser
{
    protected $kernel;

    
    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    
    public function parse($controller)
    {
        if (3 != count($parts = explode(':', $controller))) {
            throw new \InvalidArgumentException(sprintf('The "%s" controller is not a valid a:b:c controller string.', $controller));
        }

        list($bundle, $controller, $action) = $parts;
        $class = null;
        $logs = array();
        foreach ($this->kernel->getBundle($bundle, false) as $b) {
            $try = $b->getNamespace().'\\Controller\\'.$controller.'Controller';
            if (!class_exists($try)) {
                $logs[] = sprintf('Unable to find controller "%s:%s" - class "%s" does not exist.', $bundle, $controller, $try);
            } else {
                $class = $try;

                break;
            }
        }

        if (null === $class) {
            $this->handleControllerNotFoundException($bundle, $controller, $logs);
        }

        return $class.'::'.$action.'Action';
    }

    private function handleControllerNotFoundException($bundle, $controller, array $logs)
    {
                if (1 == count($logs)) {
            throw new \InvalidArgumentException($logs[0]);
        }

                $names = array();
        foreach ($this->kernel->getBundle($bundle, false) as $b) {
            $names[] = $b->getName();
        }
        $msg = sprintf('Unable to find controller "%s:%s" in bundles %s.', $bundle, $controller, implode(', ', $names));

        throw new \InvalidArgumentException($msg);
    }
}
}
 



namespace Symfony\Bundle\FrameworkBundle\Controller
{

use Symfony\Component\HttpKernel\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolver as BaseControllerResolver;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\ControllerNameParser;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;


class ControllerResolver extends BaseControllerResolver
{
    protected $container;
    protected $parser;

    
    public function __construct(ContainerInterface $container, ControllerNameParser $parser, LoggerInterface $logger = null)
    {
        $this->container = $container;
        $this->parser = $parser;

        parent::__construct($logger);
    }

    
    protected function createController($controller)
    {
        if (false === strpos($controller, '::')) {
            $count = substr_count($controller, ':');
            if (2 == $count) {
                                $controller = $this->parser->parse($controller);
            } elseif (1 == $count) {
                                list($service, $method) = explode(':', $controller);

                return array($this->container->get($service), $method);
            } else {
                throw new \LogicException(sprintf('Unable to parse the controller name "%s".', $controller));
            }
        }

        list($class, $method) = explode('::', $controller);

        if (!class_exists($class)) {
            throw new \InvalidArgumentException(sprintf('Class "%s" does not exist.', $class));
        }

        $controller = new $class();
        if ($controller instanceof ContainerAwareInterface) {
            $controller->setContainer($this->container);
        }

        return array($controller, $method);
    }
}
}
 



namespace Symfony\Bundle\FrameworkBundle\Controller
{

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilder;
use Symfony\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpFoundation\Request;


class Controller extends ContainerAware
{
    
    public function generateUrl($route, array $parameters = array(), $absolute = false)
    {
        return $this->container->get('router')->generate($route, $parameters, $absolute);
    }

    
    public function forward($controller, array $path = array(), array $query = array())
    {
        return $this->container->get('http_kernel')->forward($controller, $path, $query);
    }

    
    public function redirect($url, $status = 302)
    {
        return new RedirectResponse($url, $status);
    }

    
    public function renderView($view, array $parameters = array())
    {
        return $this->container->get('templating')->render($view, $parameters);
    }

    
    public function render($view, array $parameters = array(), Response $response = null)
    {
        return $this->container->get('templating')->renderResponse($view, $parameters, $response);
    }

    
    public function createNotFoundException($message = 'Not Found', \Exception $previous = null)
    {
        return new NotFoundHttpException($message, $previous);
    }

    
    public function createForm($type, $data = null, array $options = array())
    {
        return $this->container->get('form.factory')->create($type, $data, $options);
    }

    
    public function createFormBuilder($data = null, array $options = array())
    {
        return $this->container->get('form.factory')->createBuilder('form', $data, $options);
    }

    
    public function getRequest()
    {
        return $this->container->get('request');
    }

    
    public function getDoctrine()
    {
        if (!$this->container->has('doctrine')) {
            throw new \LogicException('The DoctrineBundle is not installed in your application.');
        }

        return $this->container->get('doctrine');
    }

    
    public function has($id)
    {
        return $this->container->has($id);
    }

    
    public function get($id)
    {
        return $this->container->get($id);
    }
}
}
 



namespace Symfony\Bundle\FrameworkBundle
{

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\Event;


class ContainerAwareEventDispatcher extends EventDispatcher
{
    
    private $container;

    
    private $listenerIds = array();

    
    private $listeners = array();

    
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    
    public function addListenerService($eventName, $callback, $priority = 0)
    {
        if (!is_array($callback) || 2 !== count($callback)) {
            throw new \InvalidArgumentException('Expected an array("service", "method") argument');
        }

        $this->listenerIds[$eventName][] = array($callback[0], $callback[1], $priority);
    }

    
    public function dispatch($eventName, Event $event = null)
    {
        if (isset($this->listenerIds[$eventName])) {
            foreach ($this->listenerIds[$eventName] as $args) {
                list($serviceId, $method, $priority) = $args;
                $listener = $this->container->get($serviceId);

                $key = $serviceId.$method;
                if (!isset($this->listeners[$eventName][$key])) {
                    $this->addListener($eventName, array($listener, $method), $priority);
                } elseif ($listener !== $this->listeners[$eventName][$key]) {
                    $this->removeListener($eventName, array($this->listeners[$eventName][$key], $method));
                    $this->addListener($eventName, array($listener, $method), $priority);
                }

                $this->listeners[$eventName][$key] = $listener;
            }
        }

        parent::dispatch($eventName, $event);
    }
}
}
 



namespace Symfony\Component\Security\Http
{

use Symfony\Component\HttpFoundation\RequestMatcherInterface;
use Symfony\Component\HttpFoundation\Request;


class AccessMap
{
    private $map = array();

    
    public function add(RequestMatcherInterface $requestMatcher, array $roles = array(), $channel = null)
    {
        $this->map[] = array($requestMatcher, $roles, $channel);
    }

    public function getPatterns(Request $request)
    {
        foreach ($this->map as $elements) {
            if (null === $elements[0] || $elements[0]->matches($request)) {
                return array($elements[1], $elements[2]);
            }
        }

        return array(null, null);
    }
}
}
 



namespace Symfony\Component\Security\Http
{

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;


class Firewall
{
    private $map;
    private $dispatcher;

    
    public function __construct(FirewallMapInterface $map, EventDispatcherInterface $dispatcher)
    {
        $this->map = $map;
        $this->dispatcher = $dispatcher;
    }

    
    public function onKernelRequest(GetResponseEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }

                list($listeners, $exception) = $this->map->getListeners($event->getRequest());
        if (null !== $exception) {
            $exception->register($this->dispatcher);
        }

                foreach ($listeners as $listener) {
            $response = $listener->handle($event);

            if ($event->hasResponse()) {
                break;
            }
        }
    }
}
}
 



namespace Symfony\Component\Security\Http
{

use Symfony\Component\HttpFoundation\Request;


interface FirewallMapInterface
{
    
    function getListeners(Request $request);
}
}
 



namespace Symfony\Component\Security\Core
{

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Acl\Voter\FieldVote;


class SecurityContext implements SecurityContextInterface
{
    private $token;
    private $accessDecisionManager;
    private $authenticationManager;
    private $alwaysAuthenticate;

    
    public function __construct(AuthenticationManagerInterface $authenticationManager, AccessDecisionManagerInterface $accessDecisionManager, $alwaysAuthenticate = false)
    {
        $this->authenticationManager = $authenticationManager;
        $this->accessDecisionManager = $accessDecisionManager;
        $this->alwaysAuthenticate = $alwaysAuthenticate;
    }

    
    public final function isGranted($attributes, $object = null)
    {
        if (null === $this->token) {
            throw new AuthenticationCredentialsNotFoundException('The security context contains no authentication token. One possible reason may be that there is no firewall configured for this URL.');
        }

        if ($this->alwaysAuthenticate || !$this->token->isAuthenticated()) {
            $this->token = $this->authenticationManager->authenticate($this->token);
        }

        return $this->accessDecisionManager->decide($this->token, (array) $attributes, $object);
    }

    
    public function getToken()
    {
        return $this->token;
    }

    
    public function setToken(TokenInterface $token = null)
    {
        $this->token = $token;
    }
}
}
 



namespace Symfony\Component\Security\Core
{

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;


interface SecurityContextInterface
{
    const ACCESS_DENIED_ERROR  = '_security.403_error';
    const AUTHENTICATION_ERROR = '_security.last_error';
    const LAST_USERNAME        = '_security.last_username';

    
    function getToken();

    
    function setToken(TokenInterface $token = null);

    
    function isGranted($attributes, $object = null);
}
}
 



namespace Symfony\Component\Security\Core\User
{


interface UserProviderInterface
{
    
    function loadUserByUsername($username);

    
    function refreshUser(UserInterface $user);

    
    function supportsClass($class);
}
}
 



namespace Symfony\Component\Security\Core\Authentication
{

use Symfony\Component\Security\Core\Exception\AccountStatusException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\ProviderNotFoundException;
use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;


class AuthenticationProviderManager implements AuthenticationManagerInterface
{
    private $providers;
    private $eraseCredentials;

    
    public function __construct(array $providers, $eraseCredentials = true)
    {
        if (!$providers) {
            throw new \InvalidArgumentException('You must at least add one authentication provider.');
        }

        $this->providers = $providers;
        $this->eraseCredentials = (Boolean) $eraseCredentials;
    }

    
    public function authenticate(TokenInterface $token)
    {
        $lastException = null;
        $result = null;

        foreach ($this->providers as $provider) {
            if (!$provider->supports($token)) {
                continue;
            }

            try {
                $result = $provider->authenticate($token);

                if (null !== $result) {
                    break;
                }
            } catch (AccountStatusException $e) {
                $e->setExtraInformation($token);

                throw $e;
            } catch (AuthenticationException $e) {
                $lastException = $e;
            }
        }

        if (null !== $result) {
            if (true === $this->eraseCredentials) {
                $result->eraseCredentials();
            }

            return $result;
        }

        if (null === $lastException) {
            $lastException = new ProviderNotFoundException(sprintf('No Authentication Provider found for token of class "%s".', get_class($token)));
        }

        $lastException->setExtraInformation($token);

        throw $lastException;
    }
}
}
 



namespace Symfony\Component\Security\Core\Authentication
{

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;


interface AuthenticationManagerInterface
{
    
    function authenticate(TokenInterface $token);
}
}
 



namespace Symfony\Component\Security\Core\Authorization
{

use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;


class AccessDecisionManager implements AccessDecisionManagerInterface
{
    private $voters;
    private $strategy;
    private $allowIfAllAbstainDecisions;
    private $allowIfEqualGrantedDeniedDecisions;

    
    public function __construct(array $voters, $strategy = 'affirmative', $allowIfAllAbstainDecisions = false, $allowIfEqualGrantedDeniedDecisions = true)
    {
        if (!$voters) {
            throw new \InvalidArgumentException('You must at least add one voter.');
        }

        $this->voters = $voters;
        $this->strategy = 'decide'.ucfirst($strategy);
        $this->allowIfAllAbstainDecisions = (Boolean) $allowIfAllAbstainDecisions;
        $this->allowIfEqualGrantedDeniedDecisions = (Boolean) $allowIfEqualGrantedDeniedDecisions;
    }

    
    public function decide(TokenInterface $token, array $attributes, $object = null)
    {
        return $this->{$this->strategy}($token, $attributes, $object);
    }

    
    public function supportsAttribute($attribute)
    {
        foreach ($this->voters as $voter) {
            if ($voter->supportsAttribute($attribute)) {
                return true;
            }
        }

        return false;
    }

    
    public function supportsClass($class)
    {
        foreach ($this->voters as $voter) {
            if ($voter->supportsClass($class)) {
                return true;
            }
        }

        return false;
    }

    
    private function decideAffirmative(TokenInterface $token, array $attributes, $object = null)
    {
        $deny = 0;
        foreach ($this->voters as $voter) {
            $result = $voter->vote($token, $object, $attributes);
            switch ($result) {
                case VoterInterface::ACCESS_GRANTED:
                    return true;

                case VoterInterface::ACCESS_DENIED:
                    ++$deny;

                    break;

                default:
                    break;
            }
        }

        if ($deny > 0) {
            return false;
        }

        return $this->allowIfAllAbstainDecisions;
    }

    
    private function decideConsensus(TokenInterface $token, array $attributes, $object = null)
    {
        $grant = 0;
        $deny = 0;
        $abstain = 0;
        foreach ($this->voters as $voter) {
            $result = $voter->vote($token, $object, $attributes);

            switch ($result) {
                case VoterInterface::ACCESS_GRANTED:
                    ++$grant;

                    break;

                case VoterInterface::ACCESS_DENIED:
                    ++$deny;

                    break;

                default:
                    ++$abstain;

                    break;
            }
        }

        if ($grant > $deny) {
            return true;
        }

        if ($deny > $grant) {
            return false;
        }

        if ($grant == $deny && $grant != 0) {
            return $this->allowIfEqualGrantedDeniedDecisions;
        }

        return $this->allowIfAllAbstainDecisions;
    }

    
    private function decideUnanimous(TokenInterface $token, array $attributes, $object = null)
    {
        $grant = 0;
        foreach ($attributes as $attribute) {
            foreach ($this->voters as $voter) {
                $result = $voter->vote($token, $object, array($attribute));

                switch ($result) {
                    case VoterInterface::ACCESS_GRANTED:
                        ++$grant;

                        break;

                    case VoterInterface::ACCESS_DENIED:
                        return false;

                    default:
                        break;
                }
            }
        }

                if ($grant > 0) {
            return true;
        }

        return $this->allowIfAllAbstainDecisions;
    }
}
}
 



namespace Symfony\Component\Security\Core\Authorization
{

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;


interface AccessDecisionManagerInterface
{
    
    function decide(TokenInterface $token, array $attributes, $object = null);

    
    function supportsAttribute($attribute);

    
    function supportsClass($class);
}
}
 



namespace Symfony\Component\Security\Core\Authorization\Voter
{

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;


interface VoterInterface
{
    const ACCESS_GRANTED = 1;
    const ACCESS_ABSTAIN = 0;
    const ACCESS_DENIED  = -1;

    
    function supportsAttribute($attribute);

    
    function supportsClass($class);

    
    function vote(TokenInterface $token, $object, array $attributes);
}
}
 



namespace Symfony\Bundle\SecurityBundle\Security
{

use Symfony\Component\Security\Http\FirewallMapInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;


class FirewallMap implements FirewallMapInterface
{
    protected $container;
    protected $map;

    public function __construct(ContainerInterface $container, array $map)
    {
        $this->container = $container;
        $this->map = $map;
    }

    public function getListeners(Request $request)
    {
        foreach ($this->map as $contextId => $requestMatcher) {
            if (null === $requestMatcher || $requestMatcher->matches($request)) {
                return $this->container->get($contextId)->getContext();
            }
        }

        return array(array(), null);
    }
}
}
 



namespace Symfony\Bundle\SecurityBundle\Security
{

use Symfony\Component\Security\Http\Firewall\ExceptionListener;


class FirewallContext
{
    private $listeners;
    private $exceptionListener;

    public function __construct(array $listeners, ExceptionListener $exceptionListener = null)
    {
        $this->listeners = $listeners;
        $this->exceptionListener = $exceptionListener;
    }

    public function getContext()
    {
        return array($this->listeners, $this->exceptionListener);
    }
}
}
 



namespace Symfony\Component\HttpFoundation
{


class RequestMatcher implements RequestMatcherInterface
{
    private $path;
    private $host;
    private $methods;
    private $ip;
    private $attributes;

    public function __construct($path = null, $host = null, $methods = null, $ip = null, array $attributes = array())
    {
        $this->path = $path;
        $this->host = $host;
        $this->methods = $methods;
        $this->ip = $ip;
        $this->attributes = $attributes;
    }

    
    public function matchHost($regexp)
    {
        $this->host = $regexp;
    }

    
    public function matchPath($regexp)
    {
        $this->path = $regexp;
    }

    
    public function matchIp($ip)
    {
        $this->ip = $ip;
    }

    
    public function matchMethod($method)
    {
        $this->methods = array_map('strtoupper', is_array($method) ? $method : array($method));
    }

    
    public function matchAttribute($key, $regexp)
    {
        $this->attributes[$key] = $regexp;
    }

    
    public function matches(Request $request)
    {
        if (null !== $this->methods && !in_array($request->getMethod(), $this->methods)) {
            return false;
        }

        foreach ($this->attributes as $key => $pattern) {
            if (!preg_match('#'.str_replace('#', '\\#', $pattern).'#', $request->attributes->get($key))) {
                return false;
            }
        }

        if (null !== $this->path) {
            if (null !== $session = $request->getSession()) {
                $path = strtr($this->path, array('{_locale}' => $session->getLocale(), '#' => '\\#'));
            } else {
                $path = str_replace('#', '\\#', $this->path);
            }

            if (!preg_match('#'.$path.'#', $request->getPathInfo())) {
                return false;
            }
        }

        if (null !== $this->host && !preg_match('#'.str_replace('#', '\\#', $this->host).'#', $request->getHost())) {
            return false;
        }

        if (null !== $this->ip && !$this->checkIp($request->getClientIp(), $this->ip)) {
            return false;
        }

        return true;
    }

    protected function checkIp($requestIp, $ip)
    {
                if (false !== strpos($requestIp, ':')) {
            return $this->checkIp6($requestIp, $ip);
        } else {
            return $this->checkIp4($requestIp, $ip);
        }
    }

    protected function checkIp4($requestIp, $ip)
    {
        if (false !== strpos($ip, '/')) {
            list($address, $netmask) = explode('/', $ip);

            if ($netmask < 1 || $netmask > 32) {
                return false;
            }
        } else {
            $address = $ip;
            $netmask = 32;
        }

        return 0 === substr_compare(sprintf('%032b', ip2long($requestIp)), sprintf('%032b', ip2long($address)), 0, $netmask);
    }

    
    protected function checkIp6($requestIp, $ip)
    {
        list($address, $netmask) = explode('/', $ip);

        $bytes_addr = unpack("n*", inet_pton($address));
        $bytes_test = unpack("n*", inet_pton($requestIp));

        for ($i = 1, $ceil = ceil($netmask / 16); $i <= $ceil; $i++) {
            $left = $netmask - 16 * ($i-1);
            $left = ($left <= 16) ?: 16;
            $mask = ~(0xffff >> $left) & 0xffff;
            if (($bytes_addr[$i] & $mask) != ($bytes_test[$i] & $mask)) {
                return false;
            }
        }

        return true;
    }
}
}
 



namespace Symfony\Component\HttpFoundation
{


interface RequestMatcherInterface
{
    
    function matches(Request $request);
}
}

namespace
{

/*
 * This file is part of Twig.
 *
 * (c) 2009 Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
/**
 * Stores the Twig configuration.
 *
 * @package twig
 * @author  Fabien Potencier <fabien@symfony.com>
 */
class Twig_Environment
{
    const VERSION = '1.1.0-RC3';
    protected $charset;
    protected $loader;
    protected $debug;
    protected $autoReload;
    protected $cache;
    protected $lexer;
    protected $parser;
    protected $compiler;
    protected $baseTemplateClass;
    protected $extensions;
    protected $parsers;
    protected $visitors;
    protected $filters;
    protected $tests;
    protected $functions;
    protected $globals;
    protected $runtimeInitialized;
    protected $loadedTemplates;
    protected $strictVariables;
    protected $unaryOperators;
    protected $binaryOperators;
    protected $templateClassPrefix = '__TwigTemplate_';
    protected $functionCallbacks;
    protected $filterCallbacks;
    /**
     * Constructor.
     *
     * Available options:
     *
     *  * debug: When set to `true`, the generated templates have a __toString()
     *           method that you can use to display the generated nodes (default to
     *           false).
     *
     *  * charset: The charset used by the templates (default to utf-8).
     *
     *  * base_template_class: The base template class to use for generated
     *                         templates (default to Twig_Template).
     *
     *  * cache: An absolute path where to store the compiled templates, or
     *           false to disable compilation cache (default)
     *
     *  * auto_reload: Whether to reload the template is the original source changed.
     *                 If you don't provide the auto_reload option, it will be
     *                 determined automatically base on the debug value.
     *
     *  * strict_variables: Whether to ignore invalid variables in templates
     *                      (default to false).
     *
     *  * autoescape: Whether to enable auto-escaping (default to true);
     *
     *  * optimizations: A flag that indicates which optimizations to apply
     *                   (default to -1 which means that all optimizations are enabled;
     *                   set it to 0 to disable)
     *
     * @param Twig_LoaderInterface   $loader  A Twig_LoaderInterface instance
     * @param array                  $options An array of options
     */
    public function __construct(Twig_LoaderInterface $loader = null, $options = array())
    {
        if (null !== $loader) {
            $this->setLoader($loader);
        }
        $options = array_merge(array(
            'debug'               => false,
            'charset'             => 'UTF-8',
            'base_template_class' => 'Twig_Template',
            'strict_variables'    => false,
            'autoescape'          => true,
            'cache'               => false,
            'auto_reload'         => null,
            'optimizations'       => -1,
        ), $options);
        $this->debug              = (bool) $options['debug'];
        $this->charset            = $options['charset'];
        $this->baseTemplateClass  = $options['base_template_class'];
        $this->autoReload         = null === $options['auto_reload'] ? $this->debug : (bool) $options['auto_reload'];
        $this->extensions         = array(
            'core'      => new Twig_Extension_Core(),
            'escaper'   => new Twig_Extension_Escaper((bool) $options['autoescape']),
            'optimizer' => new Twig_Extension_Optimizer($options['optimizations']),
        );
        $this->strictVariables    = (bool) $options['strict_variables'];
        $this->runtimeInitialized = false;
        $this->setCache($options['cache']);
        $this->functionCallbacks = array();
        $this->filterCallbacks = array();
    }
    /**
     * Gets the base template class for compiled templates.
     *
     * @return string The base template class name
     */
    public function getBaseTemplateClass()
    {
        return $this->baseTemplateClass;
    }
    /**
     * Sets the base template class for compiled templates.
     *
     * @param string $class The base template class name
     */
    public function setBaseTemplateClass($class)
    {
        $this->baseTemplateClass = $class;
    }
    /**
     * Enables debugging mode.
     */
    public function enableDebug()
    {
        $this->debug = true;
    }
    /**
     * Disables debugging mode.
     */
    public function disableDebug()
    {
        $this->debug = false;
    }
    /**
     * Checks if debug mode is enabled.
     *
     * @return Boolean true if debug mode is enabled, false otherwise
     */
    public function isDebug()
    {
        return $this->debug;
    }
    /**
     * Enables the auto_reload option.
     */
    public function enableAutoReload()
    {
        $this->autoReload = true;
    }
    /**
     * Disables the auto_reload option.
     */
    public function disableAutoReload()
    {
        $this->autoReload = false;
    }
    /**
     * Checks if the auto_reload option is enabled.
     *
     * @return Boolean true if auto_reload is enabled, false otherwise
     */
    public function isAutoReload()
    {
        return $this->autoReload;
    }
    /**
     * Enables the strict_variables option.
     */
    public function enableStrictVariables()
    {
        $this->strictVariables = true;
    }
    /**
     * Disables the strict_variables option.
     */
    public function disableStrictVariables()
    {
        $this->strictVariables = false;
    }
    /**
     * Checks if the strict_variables option is enabled.
     *
     * @return Boolean true if strict_variables is enabled, false otherwise
     */
    public function isStrictVariables()
    {
        return $this->strictVariables;
    }
    /**
     * Gets the cache directory or false if cache is disabled.
     *
     * @return string|false
     */
    public function getCache()
    {
        return $this->cache;
    }
     /**
      * Sets the cache directory or false if cache is disabled.
      *
      * @param string|false $cache The absolute path to the compiled templates,
      *                            or false to disable cache
      */
    public function setCache($cache)
    {
        $this->cache = $cache ? $cache : false;
    }
    /**
     * Gets the cache filename for a given template.
     *
     * @param string $name The template name
     *
     * @return string The cache file name
     */
    public function getCacheFilename($name)
    {
        if (false === $this->cache) {
            return false;
        }
        $class = substr($this->getTemplateClass($name), strlen($this->templateClassPrefix));
        return $this->getCache().'/'.substr($class, 0, 2).'/'.substr($class, 2, 2).'/'.substr($class, 4).'.php';
    }
    /**
     * Gets the template class associated with the given string.
     *
     * @param string $name The name for which to calculate the template class name
     *
     * @return string The template class name
     */
    public function getTemplateClass($name)
    {
        return $this->templateClassPrefix.md5($this->loader->getCacheKey($name));
    }
    /**
     * Gets the template class prefix.
     *
     * @return string The template class prefix
     */
    public function getTemplateClassPrefix()
    {
        return $this->templateClassPrefix;
    }
    /**
     * Renders a template.
     *
     * @param string $name    The template name
     * @param array  $context An array of parameters to pass to the template
     *
     * @return string The rendered template
     */
    public function render($name, array $context = array())
    {
        return $this->loadTemplate($name)->render($context);
    }
    /**
     * Loads a template by name.
     *
     * @param  string  $name  The template name
     *
     * @return Twig_TemplateInterface A template instance representing the given template name
     */
    public function loadTemplate($name)
    {
        $cls = $this->getTemplateClass($name);
        if (isset($this->loadedTemplates[$cls])) {
            return $this->loadedTemplates[$cls];
        }
        if (!class_exists($cls, false)) {
            if (false === $cache = $this->getCacheFilename($name)) {
                eval('?>'.$this->compileSource($this->loader->getSource($name), $name));
            } else {
                if (!file_exists($cache) || ($this->isAutoReload() && !$this->loader->isFresh($name, filemtime($cache)))) {
                    $this->writeCacheFile($cache, $this->compileSource($this->loader->getSource($name), $name));
                }
                require_once $cache;
            }
        }
        if (!$this->runtimeInitialized) {
            $this->initRuntime();
        }
        return $this->loadedTemplates[$cls] = new $cls($this);
    }
    /**
     * Clears the internal template cache.
     */
    public function clearTemplateCache()
    {
        $this->loadedTemplates = array();
    }
    /**
     * Clears the template cache files on the filesystem.
     */
    public function clearCacheFiles()
    {
        if (false === $this->cache) {
            return;
        }
        foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->cache), RecursiveIteratorIterator::LEAVES_ONLY) as $file) {
            if ($file->isFile()) {
                @unlink($file->getPathname());
            }
        }
    }
    /**
     * Gets the Lexer instance.
     *
     * @return Twig_LexerInterface A Twig_LexerInterface instance
     */
    public function getLexer()
    {
        if (null === $this->lexer) {
            $this->lexer = new Twig_Lexer($this);
        }
        return $this->lexer;
    }
    /**
     * Sets the Lexer instance.
     *
     * @param Twig_LexerInterface A Twig_LexerInterface instance
     */
    public function setLexer(Twig_LexerInterface $lexer)
    {
        $this->lexer = $lexer;
    }
    /**
     * Tokenizes a source code.
     *
     * @param string $source The template source code
     * @param string $name   The template name
     *
     * @return Twig_TokenStream A Twig_TokenStream instance
     */
    public function tokenize($source, $name = null)
    {
        return $this->getLexer()->tokenize($source, $name);
    }
    /**
     * Gets the Parser instance.
     *
     * @return Twig_ParserInterface A Twig_ParserInterface instance
     */
    public function getParser()
    {
        if (null === $this->parser) {
            $this->parser = new Twig_Parser($this);
        }
        return $this->parser;
    }
    /**
     * Sets the Parser instance.
     *
     * @param Twig_ParserInterface A Twig_ParserInterface instance
     */
    public function setParser(Twig_ParserInterface $parser)
    {
        $this->parser = $parser;
    }
    /**
     * Parses a token stream.
     *
     * @param Twig_TokenStream $tokens A Twig_TokenStream instance
     *
     * @return Twig_Node_Module A Node tree
     */
    public function parse(Twig_TokenStream $tokens)
    {
        return $this->getParser()->parse($tokens);
    }
    /**
     * Gets the Compiler instance.
     *
     * @return Twig_CompilerInterface A Twig_CompilerInterface instance
     */
    public function getCompiler()
    {
        if (null === $this->compiler) {
            $this->compiler = new Twig_Compiler($this);
        }
        return $this->compiler;
    }
    /**
     * Sets the Compiler instance.
     *
     * @param Twig_CompilerInterface $compiler A Twig_CompilerInterface instance
     */
    public function setCompiler(Twig_CompilerInterface $compiler)
    {
        $this->compiler = $compiler;
    }
    /**
     * Compiles a Node.
     *
     * @param Twig_NodeInterface $node A Twig_NodeInterface instance
     *
     * @return string The compiled PHP source code
     */
    public function compile(Twig_NodeInterface $node)
    {
        return $this->getCompiler()->compile($node)->getSource();
    }
    /**
     * Compiles a template source code.
     *
     * @param string $source The template source code
     * @param string $name   The template name
     *
     * @return string The compiled PHP source code
     */
    public function compileSource($source, $name = null)
    {
        try {
            return $this->compile($this->parse($this->tokenize($source, $name)));
        } catch (Twig_Error $e) {
            $e->setTemplateFile($name);
            throw $e;
        } catch (Exception $e) {
            throw new Twig_Error_Runtime(sprintf('An exception has been thrown during the compilation of a template ("%s").', $e->getMessage()), -1, $name, $e);
        }
    }
    /**
     * Sets the Loader instance.
     *
     * @param Twig_LoaderInterface $loader A Twig_LoaderInterface instance
     */
    public function setLoader(Twig_LoaderInterface $loader)
    {
        $this->loader = $loader;
    }
    /**
     * Gets the Loader instance.
     *
     * @return Twig_LoaderInterface A Twig_LoaderInterface instance
     */
    public function getLoader()
    {
        return $this->loader;
    }
    /**
     * Sets the default template charset.
     *
     * @param string $charset The default charset
     */
    public function setCharset($charset)
    {
        $this->charset = $charset;
    }
    /**
     * Gets the default template charset.
     *
     * @return string The default charset
     */
    public function getCharset()
    {
        return $this->charset;
    }
    /**
     * Initializes the runtime environment.
     */
    public function initRuntime()
    {
        $this->runtimeInitialized = true;
        foreach ($this->getExtensions() as $extension) {
            $extension->initRuntime($this);
        }
    }
    /**
     * Returns true if the given extension is registered.
     *
     * @param string $name The extension name
     *
     * @return Boolean Whether the extension is registered or not
     */
    public function hasExtension($name)
    {
        return isset($this->extensions[$name]);
    }
    /**
     * Gets an extension by name.
     *
     * @param string $name The extension name
     *
     * @return Twig_ExtensionInterface A Twig_ExtensionInterface instance
     */
    public function getExtension($name)
    {
        if (!isset($this->extensions[$name])) {
            throw new Twig_Error_Runtime(sprintf('The "%s" extension is not enabled.', $name));
        }
        return $this->extensions[$name];
    }
    /**
     * Registers an extension.
     *
     * @param Twig_ExtensionInterface $extension A Twig_ExtensionInterface instance
     */
    public function addExtension(Twig_ExtensionInterface $extension)
    {
        $this->extensions[$extension->getName()] = $extension;
    }
    /**
     * Removes an extension by name.
     *
     * @param string $name The extension name
     */
    public function removeExtension($name)
    {
        unset($this->extensions[$name]);
    }
    /**
     * Registers an array of extensions.
     *
     * @param array $extensions An array of extensions
     */
    public function setExtensions(array $extensions)
    {
        foreach ($extensions as $extension) {
            $this->addExtension($extension);
        }
    }
    /**
     * Returns all registered extensions.
     *
     * @return array An array of extensions
     */
    public function getExtensions()
    {
        return $this->extensions;
    }
    /**
     * Registers a Token Parser.
     *
     * @param Twig_TokenParserInterface $parser A Twig_TokenParserInterface instance
     */
    public function addTokenParser(Twig_TokenParserInterface $parser)
    {
        if (null === $this->parsers) {
            $this->getTokenParsers();
        }
        $this->parsers->addTokenParser($parser);
    }
    /**
     * Gets the registered Token Parsers.
     *
     * @return Twig_TokenParserInterface[] An array of Twig_TokenParserInterface instances
     */
    public function getTokenParsers()
    {
        if (null === $this->parsers) {
            $this->parsers = new Twig_TokenParserBroker;
            foreach ($this->getExtensions() as $extension) {
                $parsers = $extension->getTokenParsers();
                foreach($parsers as $parser) {
                    if ($parser instanceof Twig_TokenParserInterface) {
                        $this->parsers->addTokenParser($parser);
                    } else if ($parser instanceof Twig_TokenParserBrokerInterface) {
                        $this->parsers->addTokenParserBroker($parser);
                    } else {
                        throw new Twig_Error_Runtime('getTokenParsers() must return an array of Twig_TokenParserInterface or Twig_TokenParserBrokerInterface instances');
                    }
                }
            }
        }
        return $this->parsers;
    }
    /**
     * Registers a Node Visitor.
     *
     * @param Twig_NodeVisitorInterface $visitor A Twig_NodeVisitorInterface instance
     */
    public function addNodeVisitor(Twig_NodeVisitorInterface $visitor)
    {
        if (null === $this->visitors) {
            $this->getNodeVisitors();
        }
        $this->visitors[] = $visitor;
    }
    /**
     * Gets the registered Node Visitors.
     *
     * @return Twig_NodeVisitorInterface[] An array of Twig_NodeVisitorInterface instances
     */
    public function getNodeVisitors()
    {
        if (null === $this->visitors) {
            $this->visitors = array();
            foreach ($this->getExtensions() as $extension) {
                $this->visitors = array_merge($this->visitors, $extension->getNodeVisitors());
            }
        }
        return $this->visitors;
    }
    /**
     * Registers a Filter.
     *
     * @param string               $name    The filter name
     * @param Twig_FilterInterface $visitor A Twig_FilterInterface instance
     */
    public function addFilter($name, Twig_FilterInterface $filter)
    {
        if (null === $this->filters) {
            $this->loadFilters();
        }
        $this->filters[$name] = $filter;
    }
    /**
     * Get a filter by name.
     *
     * Subclasses may override this method and load filters differently;
     * so no list of filters is available.
     *
     * @param string $name The filter name
     *
     * @return Twig_Filter|false A Twig_Filter instance or false if the filter does not exists
     */
    public function getFilter($name)
    {
        if (null === $this->filters) {
            $this->loadFilters();
        }
        if (isset($this->filters[$name])) {
            return $this->filters[$name];
        }
        foreach ($this->filterCallbacks as $callback) {
            if (false !== $filter = call_user_func($callback, $name)) {
                return $filter;
            }
        }
        return false;
    }
    public function registerUndefinedFilterCallback($callable)
    {
        $this->filterCallbacks[] = $callable;
    }
    /**
     * Gets the registered Filters.
     *
     * @return Twig_FilterInterface[] An array of Twig_FilterInterface instances
     */
    protected function loadFilters()
    {
        $this->filters = array();
        foreach ($this->getExtensions() as $extension) {
            $this->filters = array_merge($this->filters, $extension->getFilters());
        }
    }
    /**
     * Registers a Test.
     *
     * @param string             $name    The test name
     * @param Twig_TestInterface $visitor A Twig_TestInterface instance
     */
    public function addTest($name, Twig_TestInterface $test)
    {
        if (null === $this->tests) {
            $this->getTests();
        }
        $this->tests[$name] = $test;
    }
    /**
     * Gets the registered Tests.
     *
     * @return Twig_TestInterface[] An array of Twig_TestInterface instances
     */
    public function getTests()
    {
        if (null === $this->tests) {
            $this->tests = array();
            foreach ($this->getExtensions() as $extension) {
                $this->tests = array_merge($this->tests, $extension->getTests());
            }
        }
        return $this->tests;
    }
    /**
     * Registers a Function.
     *
     * @param string                 $name     The function name
     * @param Twig_FunctionInterface $function A Twig_FunctionInterface instance
     */
    public function addFunction($name, Twig_FunctionInterface $function)
    {
        if (null === $this->functions) {
            $this->loadFunctions();
        }
        $this->functions[$name] = $function;
    }
    /**
     * Get a function by name.
     *
     * Subclasses may override this method and load functions differently;
     * so no list of functions is available.
     *
     * @param string $name function name
     *
     * @return Twig_Function|false A Twig_Function instance or false if the function does not exists
     */
    public function getFunction($name)
    {
        if (null === $this->functions) {
            $this->loadFunctions();
        }
        if (isset($this->functions[$name])) {
            return $this->functions[$name];
        }
        foreach ($this->functionCallbacks as $callback) {
            if (false !== $function = call_user_func($callback, $name)) {
                return $function;
            }
        }
        return false;
    }
    public function registerUndefinedFunctionCallback($callable)
    {
        $this->functionCallbacks[] = $callable;
    }
    protected function loadFunctions()
    {
        $this->functions = array();
        foreach ($this->getExtensions() as $extension) {
            $this->functions = array_merge($this->functions, $extension->getFunctions());
        }
    }
    /**
     * Registers a Global.
     *
     * @param string $name  The global name
     * @param mixed  $value The global value
     */
    public function addGlobal($name, $value)
    {
        if (null === $this->globals) {
            $this->getGlobals();
        }
        $this->globals[$name] = $value;
    }
    /**
     * Gets the registered Globals.
     *
     * @return array An array of globals
     */
    public function getGlobals()
    {
        if (null === $this->globals) {
            $this->globals = array();
            foreach ($this->getExtensions() as $extension) {
                $this->globals = array_merge($this->globals, $extension->getGlobals());
            }
        }
        return $this->globals;
    }
    /**
     * Gets the registered unary Operators.
     *
     * @return array An array of unary operators
     */
    public function getUnaryOperators()
    {
        if (null === $this->unaryOperators) {
            $this->initOperators();
        }
        return $this->unaryOperators;
    }
    /**
     * Gets the registered binary Operators.
     *
     * @return array An array of binary operators
     */
    public function getBinaryOperators()
    {
        if (null === $this->binaryOperators) {
            $this->initOperators();
        }
        return $this->binaryOperators;
    }
    protected function initOperators()
    {
        $this->unaryOperators = array();
        $this->binaryOperators = array();
        foreach ($this->getExtensions() as $extension) {
            $operators = $extension->getOperators();
            if (!$operators) {
                continue;
            }
            if (2 !== count($operators)) {
                throw new InvalidArgumentException(sprintf('"%s::getOperators()" does not return a valid operators array.', get_class($extension)));
            }
            $this->unaryOperators = array_merge($this->unaryOperators, $operators[0]);
            $this->binaryOperators = array_merge($this->binaryOperators, $operators[1]);
        }
    }
    protected function writeCacheFile($file, $content)
    {
        if (!is_dir(dirname($file))) {
            mkdir(dirname($file), 0777, true);
        }
        $tmpFile = tempnam(dirname($file), basename($file));
        if (false !== @file_put_contents($tmpFile, $content)) {
            // rename does not work on Win32 before 5.2.6
            if (@rename($tmpFile, $file) || (@copy($tmpFile, $file) && unlink($tmpFile))) {
                chmod($file, 0644);
                return;
            }
        }
        throw new Twig_Error_Runtime(sprintf('Failed to write cache file "%s".', $file));
    }
}

}

namespace
{

/*
 * This file is part of Twig.
 *
 * (c) 2009 Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
/**
 * Interface implemented by extension classes.
 *
 * @package    twig
 * @author     Fabien Potencier <fabien@symfony.com>
 */
interface Twig_ExtensionInterface
{
    /**
     * Initializes the runtime environment.
     *
     * This is where you can load some file that contains filter functions for instance.
     *
     * @param Twig_Environment $environment The current Twig_Environment instance
     */
    function initRuntime(Twig_Environment $environment);
    /**
     * Returns the token parser instances to add to the existing list.
     *
     * @return array An array of Twig_TokenParserInterface or Twig_TokenParserBrokerInterface instances
     */
    function getTokenParsers();
    /**
     * Returns the node visitor instances to add to the existing list.
     *
     * @return array An array of Twig_NodeVisitorInterface instances
     */
    function getNodeVisitors();
    /**
     * Returns a list of filters to add to the existing list.
     *
     * @return array An array of filters
     */
    function getFilters();
    /**
     * Returns a list of tests to add to the existing list.
     *
     * @return array An array of tests
     */
    function getTests();
    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return array An array of functions
     */
    function getFunctions();
    /**
     * Returns a list of operators to add to the existing list.
     *
     * @return array An array of operators
     */
    function getOperators();
    /**
     * Returns a list of global functions to add to the existing list.
     *
     * @return array An array of global functions
     */
    function getGlobals();
    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    function getName();
}

}

namespace
{

/*
 * This file is part of Twig.
 *
 * (c) 2009 Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
abstract class Twig_Extension implements Twig_ExtensionInterface
{
    /**
     * Initializes the runtime environment.
     *
     * This is where you can load some file that contains filter functions for instance.
     *
     * @param Twig_Environment $environment The current Twig_Environment instance
     */
    public function initRuntime(Twig_Environment $environment)
    {
    }
    /**
     * Returns the token parser instances to add to the existing list.
     *
     * @return array An array of Twig_TokenParserInterface or Twig_TokenParserBrokerInterface instances
     */
    public function getTokenParsers()
    {
        return array();
    }
    /**
     * Returns the node visitor instances to add to the existing list.
     *
     * @return array An array of Twig_NodeVisitorInterface instances
     */
    public function getNodeVisitors()
    {
        return array();
    }
    /**
     * Returns a list of filters to add to the existing list.
     *
     * @return array An array of filters
     */
    public function getFilters()
    {
        return array();
    }
    /**
     * Returns a list of tests to add to the existing list.
     *
     * @return array An array of tests
     */
    public function getTests()
    {
        return array();
    }
    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return array An array of functions
     */
    public function getFunctions()
    {
        return array();
    }
    /**
     * Returns a list of operators to add to the existing list.
     *
     * @return array An array of operators
     */
    public function getOperators()
    {
        return array();
    }
    /**
     * Returns a list of global functions to add to the existing list.
     *
     * @return array An array of global functions
     */
    public function getGlobals()
    {
        return array();
    }
}

}

namespace
{

/*
 * This file is part of Twig.
 *
 * (c) 2009 Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class Twig_Extension_Core extends Twig_Extension
{
    /**
     * Returns the token parser instance to add to the existing list.
     *
     * @return array An array of Twig_TokenParser instances
     */
    public function getTokenParsers()
    {
        return array(
            new Twig_TokenParser_For(),
            new Twig_TokenParser_If(),
            new Twig_TokenParser_Extends(),
            new Twig_TokenParser_Include(),
            new Twig_TokenParser_Block(),
            new Twig_TokenParser_Use(),
            new Twig_TokenParser_Filter(),
            new Twig_TokenParser_Macro(),
            new Twig_TokenParser_Import(),
            new Twig_TokenParser_From(),
            new Twig_TokenParser_Set(),
            new Twig_TokenParser_Spaceless(),
        );
    }
    /**
     * Returns a list of filters to add to the existing list.
     *
     * @return array An array of filters
     */
    public function getFilters()
    {
        $filters = array(
            // formatting filters
            'date'    => new Twig_Filter_Function('twig_date_format_filter'),
            'format'  => new Twig_Filter_Function('sprintf'),
            'replace' => new Twig_Filter_Function('twig_strtr'),
            // encoding
            'url_encode'  => new Twig_Filter_Function('twig_urlencode_filter'),
            'json_encode' => new Twig_Filter_Function('twig_jsonencode_filter'),
            // string filters
            'title'      => new Twig_Filter_Function('twig_title_string_filter', array('needs_environment' => true)),
            'capitalize' => new Twig_Filter_Function('twig_capitalize_string_filter', array('needs_environment' => true)),
            'upper'      => new Twig_Filter_Function('strtoupper'),
            'lower'      => new Twig_Filter_Function('strtolower'),
            'striptags'  => new Twig_Filter_Function('strip_tags'),
            // array helpers
            'join'    => new Twig_Filter_Function('twig_join_filter'),
            'reverse' => new Twig_Filter_Function('twig_reverse_filter'),
            'length'  => new Twig_Filter_Function('twig_length_filter', array('needs_environment' => true)),
            'sort'    => new Twig_Filter_Function('twig_sort_filter'),
            'merge'   => new Twig_Filter_Function('twig_array_merge'),
            // iteration and runtime
            'default' => new Twig_Filter_Function('twig_default_filter'),
            'keys'    => new Twig_Filter_Function('twig_get_array_keys_filter'),
            // escaping
            'escape' => new Twig_Filter_Function('twig_escape_filter', array('needs_environment' => true, 'is_safe_callback' => 'twig_escape_filter_is_safe')),
            'e'      => new Twig_Filter_Function('twig_escape_filter', array('needs_environment' => true, 'is_safe_callback' => 'twig_escape_filter_is_safe')),
        );
        if (function_exists('mb_get_info')) {
            $filters['upper'] = new Twig_Filter_Function('twig_upper_filter', array('needs_environment' => true));
            $filters['lower'] = new Twig_Filter_Function('twig_lower_filter', array('needs_environment' => true));
        }
        return $filters;
    }
    /**
     * Returns a list of global functions to add to the existing list.
     *
     * @return array An array of global functions
     */
    public function getFunctions()
    {
        return array(
            'range'    => new Twig_Function_Method($this, 'getRange'),
            'constant' => new Twig_Function_Method($this, 'getConstant'),
            'cycle'    => new Twig_Function_Method($this, 'getCycle'),
        );
    }
    public function getRange($start, $end, $step = 1)
    {
        return range($start, $end, $step);
    }
    public function getConstant($value)
    {
        return constant($value);
    }
    public function getCycle($values, $i)
    {
        if (!is_array($values) && !$values instanceof ArrayAccess) {
            return $values;
        }
        return $values[$i % count($values)];
    }
    /**
     * Returns a list of filters to add to the existing list.
     *
     * @return array An array of filters
     */
    public function getTests()
    {
        return array(
            'even'        => new Twig_Test_Function('twig_test_even'),
            'odd'         => new Twig_Test_Function('twig_test_odd'),
            'defined'     => new Twig_Test_Function('twig_test_defined'),
            'sameas'      => new Twig_Test_Function('twig_test_sameas'),
            'none'        => new Twig_Test_Function('twig_test_none'),
            'null'        => new Twig_Test_Function('twig_test_none'),
            'divisibleby' => new Twig_Test_Function('twig_test_divisibleby'),
            'constant'    => new Twig_Test_Function('twig_test_constant'),
            'empty'       => new Twig_Test_Function('twig_test_empty'),
        );
    }
    /**
     * Returns a list of operators to add to the existing list.
     *
     * @return array An array of operators
     */
    public function getOperators()
    {
        return array(
            array(
                'not' => array('precedence' => 50, 'class' => 'Twig_Node_Expression_Unary_Not'),
                '-'   => array('precedence' => 50, 'class' => 'Twig_Node_Expression_Unary_Neg'),
                '+'   => array('precedence' => 50, 'class' => 'Twig_Node_Expression_Unary_Pos'),
            ),
            array(
                'or'     => array('precedence' => 10, 'class' => 'Twig_Node_Expression_Binary_Or', 'associativity' => Twig_ExpressionParser::OPERATOR_LEFT),
                'and'    => array('precedence' => 15, 'class' => 'Twig_Node_Expression_Binary_And', 'associativity' => Twig_ExpressionParser::OPERATOR_LEFT),
                '=='     => array('precedence' => 20, 'class' => 'Twig_Node_Expression_Binary_Equal', 'associativity' => Twig_ExpressionParser::OPERATOR_LEFT),
                '!='     => array('precedence' => 20, 'class' => 'Twig_Node_Expression_Binary_NotEqual', 'associativity' => Twig_ExpressionParser::OPERATOR_LEFT),
                '<'      => array('precedence' => 20, 'class' => 'Twig_Node_Expression_Binary_Less', 'associativity' => Twig_ExpressionParser::OPERATOR_LEFT),
                '>'      => array('precedence' => 20, 'class' => 'Twig_Node_Expression_Binary_Greater', 'associativity' => Twig_ExpressionParser::OPERATOR_LEFT),
                '>='     => array('precedence' => 20, 'class' => 'Twig_Node_Expression_Binary_GreaterEqual', 'associativity' => Twig_ExpressionParser::OPERATOR_LEFT),
                '<='     => array('precedence' => 20, 'class' => 'Twig_Node_Expression_Binary_LessEqual', 'associativity' => Twig_ExpressionParser::OPERATOR_LEFT),
                'not in' => array('precedence' => 20, 'class' => 'Twig_Node_Expression_Binary_NotIn', 'associativity' => Twig_ExpressionParser::OPERATOR_LEFT),
                'in'     => array('precedence' => 20, 'class' => 'Twig_Node_Expression_Binary_In', 'associativity' => Twig_ExpressionParser::OPERATOR_LEFT),
                '+'      => array('precedence' => 30, 'class' => 'Twig_Node_Expression_Binary_Add', 'associativity' => Twig_ExpressionParser::OPERATOR_LEFT),
                '-'      => array('precedence' => 30, 'class' => 'Twig_Node_Expression_Binary_Sub', 'associativity' => Twig_ExpressionParser::OPERATOR_LEFT),
                '~'      => array('precedence' => 40, 'class' => 'Twig_Node_Expression_Binary_Concat', 'associativity' => Twig_ExpressionParser::OPERATOR_LEFT),
                '*'      => array('precedence' => 60, 'class' => 'Twig_Node_Expression_Binary_Mul', 'associativity' => Twig_ExpressionParser::OPERATOR_LEFT),
                '/'      => array('precedence' => 60, 'class' => 'Twig_Node_Expression_Binary_Div', 'associativity' => Twig_ExpressionParser::OPERATOR_LEFT),
                '//'     => array('precedence' => 60, 'class' => 'Twig_Node_Expression_Binary_FloorDiv', 'associativity' => Twig_ExpressionParser::OPERATOR_LEFT),
                '%'      => array('precedence' => 60, 'class' => 'Twig_Node_Expression_Binary_Mod', 'associativity' => Twig_ExpressionParser::OPERATOR_LEFT),
                'is'     => array('precedence' => 100, 'callable' => array($this, 'parseTestExpression'), 'associativity' => Twig_ExpressionParser::OPERATOR_LEFT),
                'is not' => array('precedence' => 100, 'callable' => array($this, 'parseNotTestExpression'), 'associativity' => Twig_ExpressionParser::OPERATOR_LEFT),
                '..'     => array('precedence' => 110, 'class' => 'Twig_Node_Expression_Binary_Range', 'associativity' => Twig_ExpressionParser::OPERATOR_LEFT),
                '**'     => array('precedence' => 200, 'class' => 'Twig_Node_Expression_Binary_Power', 'associativity' => Twig_ExpressionParser::OPERATOR_RIGHT),
            ),
        );
    }
    public function parseNotTestExpression(Twig_Parser $parser, $node)
    {
        return new Twig_Node_Expression_Unary_Not($this->parseTestExpression($parser, $node), $parser->getCurrentToken()->getLine());
    }
    public function parseTestExpression(Twig_Parser $parser, $node)
    {
        $stream = $parser->getStream();
        $name = $stream->expect(Twig_Token::NAME_TYPE);
        $arguments = null;
        if ($stream->test(Twig_Token::PUNCTUATION_TYPE, '(')) {
            $arguments = $parser->getExpressionParser()->parseArguments();
        }
        return new Twig_Node_Expression_Test($node, $name->getValue(), $arguments, $parser->getCurrentToken()->getLine());
    }
    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'core';
    }
}
function twig_date_format_filter($date, $format = 'F j, Y H:i', $timezone = null)
{
    if (!$date instanceof DateTime) {
        if (ctype_digit((string) $date)) {
            $date = new DateTime('@'.$date);
            $date->setTimezone(new DateTimeZone(date_default_timezone_get()));
        } else {
            $date = new DateTime($date);
        }
    }
    if (null !== $timezone) {
        if (!$timezone instanceof DateTimeZone) {
            $timezone = new DateTimeZone($timezone);
        }
        $date->setTimezone($timezone);
    }
    return $date->format($format);
}
function twig_urlencode_filter($url, $raw = false)
{
    if ($raw) {
        return rawurlencode($url);
    }
    return urlencode($url);
}
function twig_jsonencode_filter($value, $options = 0)
{
    if ($value instanceof Twig_Markup) {
        $value = (string) $value;
    } elseif (is_array($value)) {
        array_walk_recursive($value, '_twig_markup2string');
    }
    return json_encode($value, $options);
}
function _twig_markup2string(&$value)
{
    if ($value instanceof Twig_Markup) {
        $value = (string) $value;
    }
}
function twig_array_merge($arr1, $arr2)
{
    if (!is_array($arr1) || !is_array($arr2)) {
        throw new Twig_Error_Runtime('The merge filter only work with arrays or hashes.');
    }
    return array_merge($arr1, $arr2);
}
function twig_join_filter($value, $glue = '')
{
    return implode($glue, (array) $value);
}
function twig_default_filter($value, $default = '')
{
    return twig_test_empty($value) ? $default : $value;
}
function twig_get_array_keys_filter($array)
{
    if (is_object($array) && $array instanceof Traversable) {
        return array_keys(iterator_to_array($array));
    }
    if (!is_array($array)) {
        return array();
    }
    return array_keys($array);
}
function twig_reverse_filter($array)
{
    if (is_object($array) && $array instanceof Traversable) {
        return array_reverse(iterator_to_array($array));
    }
    if (!is_array($array)) {
        return array();
    }
    return array_reverse($array);
}
function twig_sort_filter($array)
{
    asort($array);
    return $array;
}
function twig_in_filter($value, $compare)
{
    if (is_array($compare)) {
        return in_array($value, $compare);
    } elseif (is_string($compare)) {
        return false !== strpos($compare, (string) $value);
    } elseif (is_object($compare) && $compare instanceof Traversable) {
        return in_array($value, iterator_to_array($compare, false));
    }
    return false;
}
function twig_strtr($pattern, $replacements)
{
    return str_replace(array_keys($replacements), array_values($replacements), $pattern);
}
/*
 * Each type specifies a way for applying a transformation to a string
 * The purpose is for the string to be "escaped" so it is suitable for
 * the format it is being displayed in.
 *
 * For example, the string: "It's required that you enter a username & password.\n"
 * If this were to be displayed as HTML it would be sensible to turn the
 * ampersand into '&amp;' and the apostrophe into '&aps;'. However if it were
 * going to be used as a string in JavaScript to be displayed in an alert box
 * it would be right to leave the string as-is, but c-escape the apostrophe and
 * the new line.
 */
function twig_escape_filter(Twig_Environment $env, $string, $type = 'html', $charset = null)
{
    if (is_object($string) && $string instanceof Twig_Markup) {
        return $string;
    }
    if (!is_string($string) && !(is_object($string) && method_exists($string, '__toString'))) {
        return $string;
    }
    if (null === $charset) {
        $charset = $env->getCharset();
    }
    switch ($type) {
        case 'js':
            // escape all non-alphanumeric characters
            // into their \xHH or \uHHHH representations
            if ('UTF-8' != $charset) {
                $string = _twig_convert_encoding($string, 'UTF-8', $charset);
            }
            if (null === $string = preg_replace_callback('#[^\p{L}\p{N} ]#u', '_twig_escape_js_callback', $string)) {
                throw new Twig_Error_Runtime('The string to escape is not a valid UTF-8 string.');
            }
            if ('UTF-8' != $charset) {
                $string = _twig_convert_encoding($string, $charset, 'UTF-8');
            }
            return $string;
        case 'html':
            return htmlspecialchars($string, ENT_QUOTES, $charset);
        default:
            throw new Twig_Error_Runtime(sprintf('Invalid escape type "%s".', $type));
    }
}
function twig_escape_filter_is_safe(Twig_Node $filterArgs)
{
    foreach ($filterArgs as $arg) {
        if ($arg instanceof Twig_Node_Expression_Constant) {
            return array($arg->getAttribute('value'));
        } else {
            return array();
        }
        break;
    }
    return array('html');
}
if (function_exists('iconv')) {
    function _twig_convert_encoding($string, $to, $from)
    {
        return iconv($from, $to, $string);
    }
} elseif (function_exists('mb_convert_encoding')) {
    function _twig_convert_encoding($string, $to, $from)
    {
        return mb_convert_encoding($string, $to, $from);
    }
} else {
    function _twig_convert_encoding($string, $to, $from)
    {
        throw new Twig_Error_Runtime('No suitable convert encoding function (use UTF-8 as your encoding or install the iconv or mbstring extension).');
    }
}
function _twig_escape_js_callback($matches)
{
    $char = $matches[0];
    // \xHH
    if (!isset($char[1])) {
        return '\\x'.substr('00'.bin2hex($char), -2);
    }
    // \uHHHH
    $char = _twig_convert_encoding($char, 'UTF-16BE', 'UTF-8');
    return '\\u'.substr('0000'.bin2hex($char), -4);
}
// add multibyte extensions if possible
if (function_exists('mb_get_info')) {
    function twig_length_filter(Twig_Environment $env, $thing)
    {
        return is_scalar($thing) ? mb_strlen($thing, $env->getCharset()) : count($thing);
    }
    function twig_upper_filter(Twig_Environment $env, $string)
    {
        if (null !== ($charset = $env->getCharset())) {
            return mb_strtoupper($string, $charset);
        }
        return strtoupper($string);
    }
    function twig_lower_filter(Twig_Environment $env, $string)
    {
        if (null !== ($charset = $env->getCharset())) {
            return mb_strtolower($string, $charset);
        }
        return strtolower($string);
    }
    function twig_title_string_filter(Twig_Environment $env, $string)
    {
        if (null !== ($charset = $env->getCharset())) {
            return mb_convert_case($string, MB_CASE_TITLE, $charset);
        }
        return ucwords(strtolower($string));
    }
    function twig_capitalize_string_filter(Twig_Environment $env, $string)
    {
        if (null !== ($charset = $env->getCharset())) {
            return mb_strtoupper(mb_substr($string, 0, 1, $charset), $charset).
                         mb_strtolower(mb_substr($string, 1, mb_strlen($string, $charset), $charset), $charset);
        }
        return ucfirst(strtolower($string));
    }
}
// and byte fallback
else
{
    function twig_length_filter(Twig_Environment $env, $thing)
    {
        return is_scalar($thing) ? strlen($thing) : count($thing);
    }
    function twig_title_string_filter(Twig_Environment $env, $string)
    {
        return ucwords(strtolower($string));
    }
    function twig_capitalize_string_filter(Twig_Environment $env, $string)
    {
        return ucfirst(strtolower($string));
    }
}
function twig_ensure_traversable($seq)
{
    if (is_array($seq) || (is_object($seq) && $seq instanceof Traversable)) {
        return $seq;
    } else {
        return array();
    }
}
function twig_test_sameas($value, $test)
{
    return $value === $test;
}
function twig_test_none($value)
{
    return null === $value;
}
function twig_test_divisibleby($value, $num)
{
    return 0 == $value % $num;
}
function twig_test_even($value)
{
    return $value % 2 == 0;
}
function twig_test_odd($value)
{
    return $value % 2 == 1;
}
function twig_test_constant($value, $constant)
{
    return constant($constant) === $value;
}
function twig_test_defined($name, $context)
{
    return array_key_exists($name, $context);
}
function twig_test_empty($value)
{
    return false === $value || (empty($value) && '0' != $value);
}

}

namespace
{

/*
 * This file is part of Twig.
 *
 * (c) 2009 Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class Twig_Extension_Escaper extends Twig_Extension
{
    protected $autoescape;
    public function __construct($autoescape = true)
    {
        $this->autoescape = $autoescape;
    }
    /**
     * Returns the token parser instances to add to the existing list.
     *
     * @return array An array of Twig_TokenParserInterface or Twig_TokenParserBrokerInterface instances
     */
    public function getTokenParsers()
    {
        return array(new Twig_TokenParser_AutoEscape());
    }
    /**
     * Returns the node visitor instances to add to the existing list.
     *
     * @return array An array of Twig_NodeVisitorInterface instances
     */
    public function getNodeVisitors()
    {
        return array(new Twig_NodeVisitor_Escaper());
    }
    /**
     * Returns a list of filters to add to the existing list.
     *
     * @return array An array of filters
     */
    public function getFilters()
    {
        return array(
            'raw' => new Twig_Filter_Function('twig_raw_filter', array('is_safe' => array('all'))),
        );
    }
    public function isGlobal()
    {
        return $this->autoescape;
    }
    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'escaper';
    }
}
// tells the escaper node visitor that the string is safe
function twig_raw_filter($string)
{
    return $string;
}

}

namespace
{

/*
 * This file is part of Twig.
 *
 * (c) 2010 Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class Twig_Extension_Optimizer extends Twig_Extension
{
    protected $optimizers;
    public function __construct($optimizers = -1)
    {
        $this->optimizers = $optimizers;
    }
    /**
     * {@inheritdoc}
     */
    public function getNodeVisitors()
    {
        return array(new Twig_NodeVisitor_Optimizer($this->optimizers));
    }
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'optimizer';
    }
}

}

namespace
{

/*
 * This file is part of Twig.
 *
 * (c) 2009 Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
/**
 * Interface all loaders must implement.
 *
 * @package    twig
 * @author     Fabien Potencier <fabien@symfony.com>
 */
interface Twig_LoaderInterface
{
    /**
     * Gets the source code of a template, given its name.
     *
     * @param  string $name The name of the template to load
     *
     * @return string The template source code
     */
    function getSource($name);
    /**
     * Gets the cache key to use for the cache for a given template name.
     *
     * @param  string $name The name of the template to load
     *
     * @return string The cache key
     */
    function getCacheKey($name);
    /**
     * Returns true if the template is still fresh.
     *
     * @param string    $name The template name
     * @param timestamp $time The last modification time of the cached template
     */
    function isFresh($name, $time);
}

}

namespace
{

/*
 * This file is part of Twig.
 *
 * (c) 2010 Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
/**
 * Marks a content as safe.
 *
 * @package    twig
 * @author     Fabien Potencier <fabien@symfony.com>
 */
class Twig_Markup
{
    protected $content;
    public function __construct($content)
    {
        $this->content = (string) $content;
    }
    public function __toString()
    {
        return $this->content;
    }
}

}

namespace
{

/*
 * This file is part of Twig.
 *
 * (c) 2009 Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
/**
 * Interface implemented by all compiled templates.
 *
 * @package twig
 * @author  Fabien Potencier <fabien@symfony.com>
 */
interface Twig_TemplateInterface
{
    const ANY_CALL    = 'any';
    const ARRAY_CALL  = 'array';
    const METHOD_CALL = 'method';
    /**
     * Renders the template with the given context and returns it as string.
     *
     * @param array $context An array of parameters to pass to the template
     *
     * @return string The rendered template
     */
    function render(array $context);
    /**
     * Displays the template with the given context.
     *
     * @param array $context An array of parameters to pass to the template
     * @param array $blocks  An array of blocks to pass to the template
     */
    function display(array $context, array $blocks = array());
    /**
     * Returns the bound environment for this template.
     *
     * @return Twig_Environment The current environment
     */
    function getEnvironment();
}

}

namespace
{

/*
 * This file is part of Twig.
 *
 * (c) 2009 Fabien Potencier
 * (c) 2009 Armin Ronacher
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
/**
 * Default base class for compiled templates.
 *
 * @package twig
 * @author  Fabien Potencier <fabien@symfony.com>
 */
abstract class Twig_Template implements Twig_TemplateInterface
{
    static protected $cache = array();
    protected $env;
    protected $blocks;
    /**
     * Constructor.
     *
     * @param Twig_Environment $env A Twig_Environment instance
     */
    public function __construct(Twig_Environment $env)
    {
        $this->env = $env;
        $this->blocks = array();
    }
    /**
     * Returns the template name.
     *
     * @return string The template name
     */
    public function getTemplateName()
    {
        return null;
    }
    /**
     * Returns the Twig environment.
     *
     * @return Twig_Environment The Twig environment
     */
    public function getEnvironment()
    {
        return $this->env;
    }
    /**
     * Returns the parent template.
     *
     * @return Twig_TemplateInterface|false The parent template or false if there is no parent
     */
    public function getParent(array $context)
    {
        return false;
    }
    /**
     * Displays a parent block.
     *
     * @param string $name    The block name to display from the parent
     * @param array  $context The context
     * @param array  $blocks  The current set of blocks
     */
    public function displayParentBlock($name, array $context, array $blocks = array())
    {
        if (false !== $parent = $this->getParent($context)) {
            $parent->displayBlock($name, $context, $blocks);
        } else {
            throw new Twig_Error_Runtime('This template has no parent', -1, $this->getTemplateName());
        }
    }
    /**
     * Displays a block.
     *
     * @param string $name    The block name to display
     * @param array  $context The context
     * @param array  $blocks  The current set of blocks
     */
    public function displayBlock($name, array $context, array $blocks = array())
    {
        if (isset($blocks[$name])) {
            $b = $blocks;
            unset($b[$name]);
            call_user_func($blocks[$name], $context, $b);
        } elseif (isset($this->blocks[$name])) {
            call_user_func($this->blocks[$name], $context, $blocks);
        } elseif (false !== $parent = $this->getParent($context)) {
            $parent->displayBlock($name, $context, array_merge($this->blocks, $blocks));
        }
    }
    /**
     * Renders a parent block.
     *
     * @param string $name    The block name to render from the parent
     * @param array  $context The context
     * @param array  $blocks  The current set of blocks
     *
     * @return string The rendered block
     */
    public function renderParentBlock($name, array $context, array $blocks = array())
    {
        ob_start();
        $this->displayParentBlock($name, $context, $blocks);
        return ob_get_clean();
    }
    /**
     * Renders a block.
     *
     * @param string $name    The block name to render
     * @param array  $context The context
     * @param array  $blocks  The current set of blocks
     *
     * @return string The rendered block
     */
    public function renderBlock($name, array $context, array $blocks = array())
    {
        ob_start();
        $this->displayBlock($name, $context, $blocks);
        return ob_get_clean();
    }
    /**
     * Returns whether a block exists or not.
     *
     * @param string $name The block name
     *
     * @return Boolean true if the block exists, false otherwise
     */
    public function hasBlock($name)
    {
        return isset($this->blocks[$name]);
    }
    /**
     * Returns all block names.
     *
     * @return array An array of block names
     */
    public function getBlockNames()
    {
        return array_keys($this->blocks);
    }
    /**
     * Returns all blocks.
     *
     * @return array An array of blocks
     */
    public function getBlocks()
    {
        return $this->blocks;
    }
    /**
     * Displays the template with the given context.
     *
     * @param array $context An array of parameters to pass to the template
     * @param array $blocks  An array of blocks to pass to the template
     */
    public function display(array $context, array $blocks = array())
    {
        try {
            $this->doDisplay($context, $blocks);
        } catch (Twig_Error $e) {
            throw $e;
        } catch (Exception $e) {
            throw new Twig_Error_Runtime(sprintf('An exception has been thrown during the rendering of a template ("%s").', $e->getMessage()), -1, null, $e);
        }
    }
    /**
     * Renders the template with the given context and returns it as string.
     *
     * @param array $context An array of parameters to pass to the template
     *
     * @return string The rendered template
     */
    public function render(array $context)
    {
        ob_start();
        try {
            $this->display($context);
        } catch (Exception $e) {
            // the count variable avoids an infinite loop on
            // some Windows configurations where ob_get_level()
            // never reaches 0
            $count = 100;
            while (ob_get_level() && --$count) {
                ob_end_clean();
            }
            throw $e;
        }
        return ob_get_clean();
    }
    /**
     * Auto-generated method to display the template with the given context.
     *
     * @param array $context An array of parameters to pass to the template
     * @param array $blocks  An array of blocks to pass to the template
     */
    abstract protected function doDisplay(array $context, array $blocks = array());
    /**
     * Returns a variable from the context.
     *
     * @param array   $context The context
     * @param string  $item    The variable to return from the context
     *
     * @throws Twig_Error_Runtime if the variable does not exist
     */
    protected function getContext($context, $item)
    {
        if (!array_key_exists($item, $context)) {
            throw new Twig_Error_Runtime(sprintf('Variable "%s" does not exist', $item));
        }
        return $context[$item];
    }
    /**
     * Returns the attribute value for a given array/object.
     *
     * @param mixed   $object        The object or array from where to get the item
     * @param mixed   $item          The item to get from the array or object
     * @param array   $arguments     An array of arguments to pass if the item is an object method
     * @param string  $type          The type of attribute (@see Twig_TemplateInterface)
     * @param Boolean $isDefinedTest Whether this is only a defined check
     */
    protected function getAttribute($object, $item, array $arguments = array(), $type = Twig_TemplateInterface::ANY_CALL, $isDefinedTest = false)
    {
        // array
        if (Twig_TemplateInterface::METHOD_CALL !== $type) {
            if ((is_array($object) && array_key_exists($item, $object))
                || ($object instanceof ArrayAccess && isset($object[$item]))
            ) {
                if ($isDefinedTest) {
                    return true;
                }
                return $object[$item];
            }
            if (Twig_TemplateInterface::ARRAY_CALL === $type) {
                if ($isDefinedTest) {
                    return false;
                }
                if (!$this->env->isStrictVariables()) {
                    return null;
                }
                if (is_object($object)) {
                    throw new Twig_Error_Runtime(sprintf('Key "%s" in object (with ArrayAccess) of type "%s" does not exist', $item, get_class($object)));
                // array
                } else {
                    throw new Twig_Error_Runtime(sprintf('Key "%s" for array with keys "%s" does not exist', $item, implode(', ', array_keys($object))));
                }
            }
        }
        if (!is_object($object)) {
            if ($isDefinedTest) {
                return false;
            }
            if (!$this->env->isStrictVariables()) {
                return null;
            }
            throw new Twig_Error_Runtime(sprintf('Item "%s" for "%s" does not exist', $item, $object));
        }
        // get some information about the object
        $class = get_class($object);
        if (!isset(self::$cache[$class])) {
            $r = new ReflectionClass($class);
            self::$cache[$class] = array('methods' => array(), 'properties' => array());
            foreach ($r->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
                self::$cache[$class]['methods'][strtolower($method->getName())] = true;
            }
            foreach ($r->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
                self::$cache[$class]['properties'][$property->getName()] = true;
            }
        }
        // object property
        if (Twig_TemplateInterface::METHOD_CALL !== $type) {
            if (isset(self::$cache[$class]['properties'][$item])
                || isset($object->$item) || array_key_exists($item, $object)
            ) {
                if ($isDefinedTest) {
                    return true;
                }
                if ($this->env->hasExtension('sandbox')) {
                    $this->env->getExtension('sandbox')->checkPropertyAllowed($object, $item);
                }
                return $object->$item;
            }
        }
        // object method
        $lcItem = strtolower($item);
        if (isset(self::$cache[$class]['methods'][$lcItem])) {
            $method = $item;
        } elseif (isset(self::$cache[$class]['methods']['get'.$lcItem])) {
            $method = 'get'.$item;
        } elseif (isset(self::$cache[$class]['methods']['is'.$lcItem])) {
            $method = 'is'.$item;
        } elseif (isset(self::$cache[$class]['methods']['__call'])) {
            $method = $item;
        } else {
            if ($isDefinedTest) {
                return false;
            }
            if (!$this->env->isStrictVariables()) {
                return null;
            }
            throw new Twig_Error_Runtime(sprintf('Method "%s" for object "%s" does not exist', $item, get_class($object)));
        }
        if ($isDefinedTest) {
            return true;
        }
        if ($this->env->hasExtension('sandbox')) {
            $this->env->getExtension('sandbox')->checkMethodAllowed($object, $method);
        }
        $ret = call_user_func_array(array($object, $method), $arguments);
        if ($object instanceof Twig_TemplateInterface) {
            return new Twig_Markup($ret);
        }
        return $ret;
    }
}

}
 



namespace Monolog\Formatter
{


interface FormatterInterface
{
    
    function format(array $record);

    
    function formatBatch(array $records);
}
}
 



namespace Monolog\Formatter
{

use Monolog\Logger;


class LineFormatter implements FormatterInterface
{
    const SIMPLE_FORMAT = "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n";
    const SIMPLE_DATE = "Y-m-d H:i:s";

    protected $format;
    protected $dateFormat;

    
    public function __construct($format = null, $dateFormat = null)
    {
        $this->format = $format ?: static::SIMPLE_FORMAT;
        $this->dateFormat = $dateFormat ?: static::SIMPLE_DATE;
    }

    
    public function format(array $record)
    {
        $vars = $record;
        $vars['datetime'] = $vars['datetime']->format($this->dateFormat);

        $output = $this->format;
        foreach ($vars['extra'] as $var => $val) {
            if (false !== strpos($output, '%extra.'.$var.'%')) {
                $output = str_replace('%extra.'.$var.'%', $this->convertToString($val), $output);
                unset($vars['extra'][$var]);
            }
        }
        foreach ($vars as $var => $val) {
            $output = str_replace('%'.$var.'%', $this->convertToString($val), $output);
        }

        return $output;
    }

    public function formatBatch(array $records)
    {
        $message = '';
        foreach ($records as $record) {
            $message .= $this->format($record);
        }

        return $message;
    }

    protected function convertToString($data)
    {
        if (null === $data || is_scalar($data)) {
            return (string) $data;
        }

        return stripslashes(json_encode($this->normalize($data)));
    }

    protected function normalize($data)
    {
        if (null === $data || is_scalar($data)) {
            return $data;
        }

        if (is_array($data) || $data instanceof \Traversable) {
            $normalized = array();

            foreach ($data as $key => $value) {
                $normalized[$key] = $this->normalize($value);
            }

            return $normalized;
        }

        if (is_resource($data)) {
            return '[resource]';
        }

        return sprintf("[object] (%s: %s)", get_class($data), json_encode($data));
    }
}
}
 



namespace Monolog\Handler
{

use Monolog\Logger;


class FingersCrossedHandler extends AbstractHandler
{
    protected $handler;
    protected $actionLevel;
    protected $buffering = true;
    protected $bufferSize;
    protected $buffer = array();
    protected $stopBuffering;

    
    public function __construct($handler, $actionLevel = Logger::WARNING, $bufferSize = 0, $bubble = true, $stopBuffering = true)
    {
        $this->handler = $handler;
        $this->actionLevel = $actionLevel;
        $this->bufferSize = $bufferSize;
        $this->bubble = $bubble;
        $this->stopBuffering = $stopBuffering;
    }

    
    public function isHandling(array $record)
    {
        return true;
    }

    
    public function handle(array $record)
    {
        if ($this->buffering) {
            $this->buffer[] = $record;
            if ($this->bufferSize > 0 && count($this->buffer) > $this->bufferSize) {
                array_shift($this->buffer);
            }
            if ($record['level'] >= $this->actionLevel) {
                if ($this->stopBuffering) {
                    $this->buffering = false;
                }
                if (!$this->handler instanceof HandlerInterface) {
                    $this->handler = call_user_func($this->handler, $record, $this);
                }
                if (!$this->handler instanceof HandlerInterface) {
                    throw new \RuntimeException("The factory callback should return a HandlerInterface");
                }
                $this->handler->handleBatch($this->buffer);
                $this->buffer = array();
            }
        } else {
            $this->handler->handle($record);
        }

        return false === $this->bubble;
    }

    
    public function reset()
    {
        $this->buffering = true;
    }
}
}
 



namespace JMS\SecurityExtraBundle\Controller
{

use Doctrine\Common\Annotations\Reader;
use Symfony\Component\DependencyInjection\ContainerInterface;
use JMS\SecurityExtraBundle\Metadata\Driver\AnnotationConverter;
use JMS\SecurityExtraBundle\Metadata\MethodMetadata;
use JMS\SecurityExtraBundle\Security\Authorization\Interception\MethodInvocation;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JMS\SecurityExtraBundle\Metadata\Driver\AnnotationReader;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;


class ControllerListener
{
    private $reader;
    private $converter;
    private $container;

    public function __construct(ContainerInterface $container, Reader $reader)
    {
        $this->container = $container;
        $this->reader = $reader;
        $this->converter = new AnnotationConverter();
    }

    public function onCoreController(FilterControllerEvent $event)
    {
        if (!is_array($controller = $event->getController())) {
            return;
        }

        $method = new MethodInvocation($controller[0], $controller[1], $controller[0]);
        if (!$annotations = $this->reader->getMethodAnnotations($method)) {
            return;
        }

        static $emptyMetadata = array('roles' => array(), 'run_as_roles' => array(), 'param_permissions' => array(), 'return_permissions' => array());
        if ($emptyMetadata === $jmsSecurityExtra__metadata = $this->converter->convertMethodAnnotations($method, $annotations)->getAsArray()) {
            return;
        }

        $closureCode = 'return function(';
        $params = $paramNames = array();
        foreach ($method->getParameters() as $param) {
            $name = $param->getName();
            $paramNames[] = '$'.$name;

            $parameter = '';
            if (null !== $class = $param->getClass()) {
                $parameter .= '\\'.$class->getName().' ';
            } else if ($param->isArray()) {
                $parameter .= 'array ';
            }

            $parameter .= '$'.$name;
            if ($param->isDefaultValueAvailable()) {
                $parameter .= ' = '.var_export($param->getDefaultValue(), true);
            }

            $params[] = $parameter;
        }
        $params = implode(', ', $params);
        $closureCode .= $params.') ';

        $jmsSecurityExtra__interceptor = $this->container->get('security.access.method_interceptor');
        $jmsSecurityExtra__method = $method;

        $closureCode .= 'use ($jmsSecurityExtra__metadata, $jmsSecurityExtra__interceptor, $jmsSecurityExtra__method) {';
        $closureCode .= '$jmsSecurityExtra__method->setArguments(array('.implode(', ', $paramNames).'));';
        $closureCode .= 'return $jmsSecurityExtra__interceptor->invoke($jmsSecurityExtra__method, $jmsSecurityExtra__metadata);';
        $closureCode .= '};';

        $event->setController(eval($closureCode));
    }
}
}
 



namespace JMS\SecurityExtraBundle\Metadata\Driver
{

use JMS\SecurityExtraBundle\Annotation\RunAs;
use JMS\SecurityExtraBundle\Annotation\SatisfiesParentSecurityPolicy;
use JMS\SecurityExtraBundle\Annotation\SecureReturn;
use JMS\SecurityExtraBundle\Annotation\SecureParam;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JMS\SecurityExtraBundle\Metadata\MethodMetadata;


class AnnotationConverter
{
    public function convertMethodAnnotations(\ReflectionMethod $method, array $annotations)
    {
        $parameters = array();
        foreach ($method->getParameters() as $index => $parameter) {
            $parameters[$parameter->getName()] = $index;
        }

        $methodMetadata = new MethodMetadata($method->getDeclaringClass()->getName(), $method->getName());
        foreach ($annotations as $annotation) {
            if ($annotation instanceof Secure) {
                $methodMetadata->roles = $annotation->roles;
            } else if ($annotation instanceof SecureParam) {
                if (!isset($parameters[$annotation->name])) {
                    throw new \InvalidArgumentException(sprintf('The parameter "%s" does not exist for method "%s".', $annotation->name, $method->getName()));
                }

                $methodMetadata->addParamPermissions($parameters[$annotation->name], $annotation->permissions);
            } else if ($annotation instanceof SecureReturn) {
                $methodMetadata->returnPermissions = $annotation->permissions;
            } else if ($annotation instanceof SatisfiesParentSecurityPolicy) {
                $methodMetadata->satisfiesParentSecurityPolicy = true;
            } else if ($annotation instanceof RunAs) {
                $methodMetadata->runAsRoles = $annotation->roles;
            }
        }

        return $methodMetadata;
    }
}}
 



namespace JMS\SecurityExtraBundle\Security\Authorization\Interception
{


class MethodInvocation extends \ReflectionMethod
{
    private $arguments;
    private $object;

    public function __construct($class, $name, $object, array $arguments = array())
    {
        parent::__construct($class, $name);

        if (!is_object($object)) {
            throw new \InvalidArgumentException('$object must be an object.');
        }

        $this->arguments = $arguments;
        $this->object = $object;
    }

    public function setArguments(array $arguments)
    {
        $this->arguments = $arguments;
    }

    
    public function getArguments()
    {
        return $this->arguments;
    }

    
    public function getThis()
    {
        return $this->object;
    }
}}
