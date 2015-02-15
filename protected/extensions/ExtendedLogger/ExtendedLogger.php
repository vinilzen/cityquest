<?

class ExtendedLogger extends CFileLogRoute
{
    protected function formatLogMessage($message,$level,$category,$time)
    {
        $micro = sprintf("%06d",($time - floor($time)) * 1000000);
        return date('Y-m-d H:i:s.'.$micro,$time)." [$level] [$category] $message\n";
    }
}