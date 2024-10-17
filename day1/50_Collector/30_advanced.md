!SLIDE

# Receivers

Receivers typically listen on a network port and receive telemetry data.

They can also actively obtain data, like scrapers.

Usually one receiver is configured to send received data to one pipeline.

    @@@Yaml
    receivers:
      filelog:
        include: [ /var/log/myservice/*.json ]
        operators:
          - type: json_parser
            timestamp:
              parse_from: attributes.time
              layout: '%Y-%m-%d %H:%M:%S'

~~~SECTION:handouts~~~

See: https://github.com/open-telemetry/opentelemetry-collector-contrib/tree/main/receiver

* https://github.com/open-telemetry/opentelemetry-collector-contrib/tree/main/receiver/hostmetricsreceiver
* https://github.com/open-telemetry/opentelemetry-collector-contrib/tree/main/receiver/filelogreceiver
* https://github.com/open-telemetry/opentelemetry-collector-contrib/tree/main/receiver/mysqlreceiver
* https://github.com/open-telemetry/opentelemetry-collector-contrib/tree/main/receiver/nginxreceiver
* https://github.com/open-telemetry/opentelemetry-collector-contrib/tree/main/receiver/syslogreceiver

~~~ENDSECTION~~~

!SLIDE

# Distributions

The OpenTelemetry project provides a compiled distribution of the collector.

But you easily build your own with the build distributions ocb tool (OpenTelemetry Collector Builder).

When you need custom functionality like authenticator extensions, receivers, processors, exporters or connectors.

https://opentelemetry.io/docs/collector/distributions/

!SLIDE

# OTLP

The OpenTelemetry Protocol (OTLP) defines the encoding of telemetry data and the protocol used to exchange data between the client and the server.

This specification defines how OTLP is implemented over gRPC and HTTP.

More and more vendors offer data ingestion via OTLP natively.

See: https://opentelemetry.io/docs/specs/otlp/
