!SLIDE subsection
# ~~~SECTION:MAJOR~~~ Observability Concepts

!SLIDE smbullets

# Monitoring and Observability

Monitoring is the *practice* of collecting, aggregating and processing data about a system.

* Black-box monitoring. Testing externally visible behavior as users would see it
* White-box monitoring. Observing the data/telemetry exposed by the system's internals

Observability is a *measure* of how well we can understand a system (measures the *ability* to *observe* the system).

The data generally comes in the form of traces, metrics, and logs.

!SLIDE smbullets

# Metrics

Metrics are numerical values that can be used to determine a service or component’s behavior. Examples:

    @@@Sh
    service_open_connections
    filesystem_avail_bytes
    network_receive_bytes_total
    config_last_reload_success

Metrics can originate from a variety of sources (hosts, services, external sources, etc.).

Metrics can be used to observe and compare behavior over time.

!SLIDE smbullets

# Logs

Logs are text-based events that protocol activities over time.

    @@@Sh
    Jan 10 14:30:01 pc CRON[121602]: pam_unix(cron:session):
      session opened for user root(uid=0) by (uid=0)
    Jan 10 14:30:01 pc CRON[121602]: pam_unix(cron:session):
      session closed for user root

They come in a variety of formats and are either structured (i.e. JSON) or unstructured.

Structure logs aim to create machine-readable data.

!SLIDE smbullets

# Traces

Traces are records of requests flowing through different parts of an application, which can record the duration and data for each subsystem.

    @@@render-diagram
    gantt
        title Time
        dateFormat  HH:mm
        section Request
        Get Data      :a1, 11:00, 5m
        Authenticate  :a1, 11:00, 1m
        Cache         :a1, 11:01, 1m
        DB            :a1, 11:02, 2m
        Render        :a1, 11:04, 1m

Traces represent the execution path of a request, each span in a trace represents a unit of work during this journey (e.g. API call or database query).
