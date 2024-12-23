protected function configureRateLimiting()
{
    RateLimiter::for('api', function (Request $request) {
        return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
    });

    RateLimiter::for('auth:karyawan', function (Request $request) {
        return Limit::perMinute(60)->by(optional($request->user())->nik ?: $request->ip());
    });
}
