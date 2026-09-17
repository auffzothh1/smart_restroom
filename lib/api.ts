/** Small helpers shared by every function in netlify/functions. */

export function json(data: unknown, status = 200, headers: Record<string, string> = {}) {
  return Response.json(data, {
    status,
    headers: { "cache-control": "no-store", ...headers },
  });
}

export function fail(status: number, message: string) {
  return json({ error: message }, status);
}

/** Accepts JSON bodies as well as classic form posts and query strings. */
export async function readParams(req: Request): Promise<Record<string, string>> {
  const params: Record<string, string> = {};
  for (const [key, value] of new URL(req.url).searchParams) params[key] = value;

  if (req.method === "GET" || req.method === "HEAD") return params;

  const contentType = req.headers.get("content-type") ?? "";
  try {
    if (contentType.includes("application/json")) {
      const body = await req.json();
      if (body && typeof body === "object") {
        for (const [key, value] of Object.entries(body)) params[key] = String(value ?? "");
      }
    } else if (contentType.includes("form")) {
      for (const [key, value] of await req.formData()) {
        if (typeof value === "string") params[key] = value;
      }
    }
  } catch {
    // A malformed body simply leaves the query-string values in place.
  }
  return params;
}

/** Clamps a percentage reading to 0-100, returning null when it is not a number. */
export function toPercent(value: string | undefined): number | null {
  if (value === undefined || value.trim() === "") return null;
  const parsed = Number(value);
  if (!Number.isFinite(parsed)) return null;
  return Math.min(100, Math.max(0, Math.round(parsed)));
}
