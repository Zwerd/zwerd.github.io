---
layout: post
title: "Building ThreatGate - From IIS Text Files to a Modern IOC Management Platform"
categories: [cybersecurity, development, python]
tags: [ioc, threat-intelligence, flask, soc]
---

## The Story Behind ThreatGate 🚀

So, here's the thing... 😅

Anyone who's been following my work knows that about a year ago, I built a system based on IIS that had one simple goal: to serve IOC feeds from the SOC team to various security systems in the network. I didn't overthink it - just made something super simple based on TXT files. 

*"It's just text files, how complicated can it be?"* 🤔

Well, it worked... but you know how these things go. 🤷‍♂️

Then the SOC team grew, and suddenly there were **way** more requirements popping up everywhere like mushrooms after rain:

- ❌ No tracking of who submitted what (whoops, forgot to add that!)
- ❌ Junior analysts making mistakes (putting hashes in URL files, forgetting to add their names, not documenting dates... classic!)
- ❌ Need for temporary IOC blocking (because sometimes you just need to block something for a week, not forever)
- ❌ Need to track IOCs and remove duplicates (because apparently copy-paste is hard)
- ❌ And more... and more... and MORE! 😤

*"Feature creep? What's that?"* - Me, probably 🤦‍♂️

At first, I built a simple web system that allowed analysts to update IOCs through the web interface. It gave a very minimal solution (think: "it works on my machine" level of minimal), but as time passed, the need for something more comprehensive kept growing.

*"Just one more feature..."* - Famous last words 🎭

So I decided to dust off the old development lab (literally, there was dust 🕷️) and write some proper code on Linux! 🐧

Since we have a MISP system running on Ubuntu, I decided to develop the new system alongside it - it would receive data from MISP and from analysts, and generate feeds for the various security systems in the organization. 

*"This time I'll do it right!"* - Me, definitely this time 💪

---

## Meet ThreatGate v4.0 🎯

This project is particularly close to my heart 💚, mainly because it combines several open-source projects I already knew and loved, but specifically focuses on **one thing**: IOCs. 

The goal was simple: create something that analysts would actually *want* to use, not just tolerate. Something that gives them the drive to do more cybersecurity-related work instead of just staring at screens and filling out forms. 

*"If they're going to spend 8 hours a day on this, it better be enjoyable!"* - My inner UX designer 🎨

And you know what? It worked! The modern UI, smooth animations, and intuitive workflow actually made IOC management... dare I say it... *fun*? Well, at least less painful! 😄

![ThreatGate Dashboard](/assets/images/threatgate/live_stats_intel_3col.png)

---

## What is ThreatGate?

**ThreatGate** is a modern IOC (Indicators of Compromise) and YARA rule management platform built specifically for SOC operations in **offline/air-gapped environments**. It's designed with one clear mission: receive IOCs from analysts and generate feeds that security devices (firewalls) can consume and enforce blocking rules.

### Key Features ✨

- **🔒 Offline-First Architecture**: Works completely offline - no external dependencies, no CDN, no cloud services
- **📊 Modern Glass UI**: Beautiful glassmorphism design with light/dark mode support
- **🗄️ SQLite Backend**: Fast, reliable database storage with automatic migration from legacy file-based systems
- **🎯 Campaign Management**: Visual graph representation of campaigns and their associated IOCs
- **📜 YARA Rule Management**: Upload, view, edit, and manage YARA rules
- **🌍 Multi-language Support**: English and Hebrew (עברית)
- **🔌 RESTful API**: Full API support for automated IOC management
- **📡 Multiple Feed Formats**: Support for Palo Alto, Checkpoint, and standard firewall formats

---

## The Architecture 🏗️

### Why SQLite?

For an offline SOC environment, SQLite is perfect:
- ✅ Single-file database - easy backup/restore
- ✅ No external dependencies
- ✅ Fast and reliable
- ✅ Works on any platform

### Why Flask?

Flask gives us:
- ✅ Lightweight and flexible
- ✅ Easy to deploy
- ✅ Perfect for offline environments
- ✅ Great for REST APIs

### Feed Generation

The system generates **20+ different feed endpoints**:

**Standard Feeds:**
- `/feed/ip` - IP addresses
- `/feed/domain` - Domains  
- `/feed/url` - URLs
- `/feed/hash` - All hash types
- `/feed/md5`, `/feed/sha1`, `/feed/sha256` - Specific hash types

**Palo Alto Feeds:**
- `/feed/pa/*` - URLs without protocol prefix (Palo Alto requirement)

**Checkpoint Feeds:**
- `/feed/cp/*` - CSV format with observe numbers

![Campaign Graph](/assets/images/threatgate/campaign_graph.png)

---

## Key Capabilities 🛠️

### 1. IOC Management

- **Input Validation**: Comprehensive regex patterns for all IOC types
- **Refanger Implementation**: Automatically cleans obfuscated IOCs (hxxp://, [.] patterns)
- **Allowlist Protection**: Prevents blocking critical assets
- **Expiration Management**: TTL support (1 Week, 1 Month, 3 Months, 1 Year, Permanent)
- **Duplicate Detection**: Case-insensitive duplicate prevention

### 2. Bulk Operations

- **CSV Import**: Auto-detect IOCs in any column
- **TXT Import**: Parse metadata from comments
- **Preview Before Submit**: Staging functionality to review before importing
- **Ticket ID Extraction**: Automatically extract ticket IDs from CSV columns

### 3. Campaign Visualization

The Campaign Graph feature provides an interactive visualization of campaigns and their IOCs:

- Visual representation with vis.js
- Color-coded IOC types (IP, Domain, URL, Email, Hash, YARA)
- Country flags for IP addresses
- Export campaign data to CSV

![Campaign Graph Visualization](/assets/images/threatgate/campaign_graph.png)

### 4. YARA Rule Management

- Upload `.yar` files with syntax validation
- View all YARA rules with metadata
- Preview rule content
- Edit rule metadata (ticket ID, comment, campaign)
- Campaign assignment

### 5. Search & Investigation

- Search across all IOC types and metadata
- Filter by: IOC Value, Ticket ID, User, Date, or All fields
- View expiration status (Active/Expired/Permanent)
- Edit IOC metadata inline
- View country information for IP addresses

![Search & Investigate](/assets/images/threatgate/search_investigate.png)

### 6. Statistics & Analytics

**Live Stats Dashboard:**
- Real-time statistics for all IOC types
- Top 10 countries by IP count (with flag icons)
- Top 10 TLDs by domain count
- Top 10 email domains
- Live feed of last 50 IOCs
- Auto-refresh every 10 seconds

**Champs Analysis:**
- Threat velocity chart (IOCs submitted per day)
- Analyst activity distribution (pie chart)
- Analyst leaderboard with weighted scores
- YARA uploads count as 5x points

![Champs Analysis](/assets/images/threatgate/champs_analysis_team_performance.png)

---

## Security Features 🔐

### Input Validation
- Comprehensive regex patterns for all IOC types
- Priority-based IOC type detection (URL before Domain, Email before Domain)
- Case-insensitive matching

### Safety Mechanisms
- **Allowlist Protection**: Prevents blocking critical assets
- **Path Traversal Protection**: Safe file handling for YARA rules
- **SQL Injection Protection**: Uses SQLAlchemy ORM (parameterized queries)
- **Audit Logging**: All actions logged with IP addresses

### Offline Security
- No external dependencies
- All assets are local
- Optional GeoIP (system works without it)
- No CDN usage

---

## API & Integration 🔌

ThreatGate provides a comprehensive REST API for automated IOC management:

### Create IOC
```bash
curl -X POST https://threatgate.example.com/api/v1/ioc \
  -H "Content-Type: application/json" \
  -d '{
    "type": "IP",
    "value": "192.168.1.100",
    "username": "automation",
    "comment": "Auto-detected threat",
    "expiration": "2025-12-31"
  }'
```

### Update IOC
```bash
curl -X POST https://threatgate.example.com/api/edit \
  -H "Content-Type: application/json" \
  -d '{
    "type": "IP",
    "value": "192.168.1.100",
    "comment": "Updated comment",
    "expiration": "Permanent"
  }'
```

### Health Check
```bash
curl https://threatgate.example.com/health
```

The API supports:
- ✅ IOC CRUD operations
- ✅ Campaign management
- ✅ YARA rule management
- ✅ Bulk operations
- ✅ Search and statistics

---

## Deployment 🚀

### Online Installation (Linux with Internet)

```bash
git clone <repository-url>
cd ThreatGate
sudo ./setup.sh
```

### Offline Installation (Air-Gapped)

1. **Prepare offline package** (on machine with internet):
   ```bash
   ./package_offline.sh
   ```

2. **Transfer ZIP to target server** and extract

3. **Install**:
   ```bash
   sudo ./setup.sh --offline
   ```

The system includes:
- ✅ Production-ready installation scripts
- ✅ Systemd service files
- ✅ Automatic cleanup of expired IOCs
- ✅ Comprehensive documentation

---

## Technical Highlights 💡

### Code Quality
- **Clean Architecture**: Well-separated concerns (models, routes, utilities)
- **Comprehensive Validation**: Input cleaning and validation at every step
- **Error Handling**: Proper exception handling and rollback mechanisms
- **Audit Trail**: Complete logging of all operations

### Performance
- **Efficient Queries**: Optimized database queries with proper indexing
- **Feed Caching**: (Planned) Cache feed generation for better performance
- **Streaming**: (Planned) Stream large feeds instead of loading all into memory

### User Experience
- **Modern UI**: Glassmorphism design with smooth animations
- **Real-time Updates**: Auto-refresh statistics and live feed
- **Multi-language**: English and Hebrew support
- **Responsive Design**: Works on different screen sizes

---

## What Makes This Special? 🌟

### 1. **Offline-First Design**
Unlike many modern tools that require cloud connectivity, ThreatGate is built from the ground up for offline/air-gapped environments. Every dependency is local, every asset is bundled, and the system works completely independently.

### 2. **Analyst-Centric**
The UI is designed to be enjoyable to use. We wanted analysts to actually *want* to use the system, not just tolerate it. The modern design, smooth animations, and intuitive workflow make IOC management less of a chore.

### 3. **Feed Diversity**
Supporting multiple firewall vendors (Palo Alto, Checkpoint, Standard) means the SOC team doesn't need multiple tools. One system, multiple outputs.

### 4. **Campaign Visualization**
The visual campaign graph helps analysts understand relationships between IOCs and campaigns. It's not just data - it's a story.

### 5. **Safety First**
The allowlist protection prevents accidental blocking of critical assets. This is crucial in production environments where a mistake could cause outages.

---

## Lessons Learned 📚

### What Worked Well ✅

1. **SQLite Choice**: Perfect for offline environments - easy backup, no dependencies
2. **Flask Flexibility**: Made it easy to add features incrementally
3. **Feed Format Diversity**: Supporting multiple formats from day one saved time later
4. **Refanger Implementation**: Cleaning obfuscated IOCs automatically saves analysts time

### Challenges Overcome 🎯

1. **Legacy Migration**: Built automatic migration from file-based system
2. **Feed Format Complexity**: Checkpoint CSV format required careful implementation
3. **Offline Dependencies**: Ensured all assets are local (flags, charts, etc.)
4. **Performance**: Optimized queries for large IOC datasets

---

## Future Enhancements 🔮

Some features I'm considering for future versions:

- **IOC Tagging System**: Better organization beyond campaigns
- **Confidence Scoring**: Add confidence levels to IOCs
- **IOC Relationships**: Link related IOCs together
- **Export Functionality**: Export IOCs to various formats
- **IOC History**: Complete audit trail of changes
- **Feed Customization**: Filter feeds by tags, confidence, date range

---

## Conclusion 🎉

ThreatGate started as a simple solution to a simple problem, but evolved into a comprehensive IOC management platform that the SOC team actually enjoys using. The combination of modern UI, robust backend, and offline-first architecture makes it perfect for air-gapped environments.

The project combines several open-source technologies I love (Flask, SQLite, vis.js, Chart.js) into a focused tool that does one thing really well: managing IOCs and generating feeds for security devices.

If you're working in a SOC environment and need a tool for IOC management that works offline, give ThreatGate a try! 🚀

---

## Get Started

**GitHub Repository:** [https://github.com/Zwerd/iocs_submission](https://github.com/Zwerd/iocs_submission)

**Documentation:** Check out the [README](https://github.com/Zwerd/iocs_submission/blob/main/README.md) for installation instructions, API documentation, and more.

**Features:**
- ✅ 20+ feed endpoints
- ✅ RESTful API
- ✅ Campaign management
- ✅ YARA rule management
- ✅ Bulk import/export
- ✅ Search & investigation
- ✅ Statistics & analytics
- ✅ Health check endpoint
- ✅ Offline/air-gapped support

---

*Built with ❤️ for SOC teams who need offline IOC management*
